<?php
declare(strict_types=1);

require_once __DIR__ . '/ArithmeticScienceClass.php';

use App\Libs\ArithmeticScienceClass;

function h(string $v): string
{
    return htmlspecialchars($v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function format_sanchu_cell(array $row): string
{
    $parts = array();
    $nenun = (string)($row['sanchu_nenun'] ?? '');
    $taiun = (string)($row['sanchu_taiun'] ?? '');
    $both = (string)($row['sanchu_nenun_taiun'] ?? '');
    if ($nenun !== '') {
        $parts[] = '年運：' . $nenun;
    }
    if ($taiun !== '') {
        $parts[] = '大運：' . $taiun;
    }
    if ($both !== '') {
        $parts[] = '年運＋大運：' . $both;
    }

    return implode("\n", $parts);
}

function douryoku_row_flags(array $row): array
{
    $passBoth = ($row['avg_diff'] ?? 0) > 0;
    $gaitouMatch = (
        ($row['sangou_kai'] ?? '') !== ''
        || ($row['hankai_nenun'] ?? '') !== ''
        || ($row['hankai_taiun'] ?? '') !== ''
        || ($row['shigou_nenun'] ?? '') !== ''
        || ($row['shigou_taiun'] ?? '') !== ''
    );
    $gaitou = $passBoth && $gaitouMatch;
    $jogai = (
        ($row['nenun_tenchusatsu'] ?? '') !== ''
        || ($row['taichu_nenun'] ?? '') !== ''
        || ($row['taichu_taiun'] ?? '') !== ''
        || ($row['gai_nenun'] ?? '') !== ''
        || ($row['gai_taiun'] ?? '') !== ''
        || ($row['nichi_taichu_nenun'] ?? '') !== ''
        || ($row['nichi_taichu_taiun'] ?? '') !== ''
        || ($row['sanchu_nenun'] ?? '') !== ''
        || ($row['sanchu_taiun'] ?? '') !== ''
        || ($row['sanchu_nenun_taiun'] ?? '') !== ''
    );

    return array(
        'passBoth' => $passBoth,
        'gaitou' => $gaitou,
        'jogai' => $jogai,
        'isDouryoku' => $gaitou && !$jogai,
    );
}

$default = [
    'y_inp' => (string)date('Y'),
    'm_inp' => (string)date('n'),
    'd_inp' => (string)date('j'),
    'radio' => 'm', // m | f
    'sei' => '',
    'mei' => '',
];

$input = $default;
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$src = ($method === 'POST') ? $_POST : $_GET;
foreach (array_keys($default) as $k) {
    if (isset($src[$k])) {
        $input[$k] = is_string($src[$k]) ? $src[$k] : $default[$k];
    }
}

$hasBirth = ($input['y_inp'] !== '' && $input['m_inp'] !== '' && $input['d_inp'] !== '');
$result = null;
$error = null;

if (($method === 'GET' && !empty($_GET)) || ($method === 'POST')) {
    if (!$hasBirth) {
        $error = '生年月日（年・月・日）を入力してください。';
    } else {
        try {
            $svc = new ArithmeticScienceClass();
            $result = $svc->arithmeticScienceResult($input);
        } catch (Throwable $e) {
            $error = $e->getMessage();
        }
    }
}

$douryokuAges = array();
if ($result !== null) {
    foreach ($result['resultData']['douryoku_step1'] ?? [] as $row) {
        if (douryoku_row_flags($row)['isDouryoku']) {
            $douryokuAges[] = (string)$row['age'];
        }
    }
}

?>
<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>動力チェック用サイト</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif; line-height: 1.4; margin: 0; background: #f7f7f8; color: #222; }
        .page { max-width: 1180px; margin: 0 auto; padding: 28px 20px 40px; }
        h1 { margin: 0 0 18px; font-size: 30px; letter-spacing: .02em; }
        .row { display: flex; gap: 14px; flex-wrap: wrap; align-items: end; }
        .row-names { align-items: end; margin-top: 14px; }
        .actions { display: flex; gap: 10px; align-items: center; }
        label { display: grid; gap: 6px; font-size: 14px; font-weight: 600; color: #333; }
        input[type="number"], input[type="text"] { padding: 10px 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 16px; width: 10rem; background: #fff; }
        .sex { display: flex; gap: 16px; padding: 14px 0 0; }
        .sex label { display: flex; gap: 6px; align-items: center; font-weight: 500; }
        button, .button-link { display: inline-flex; align-items: center; justify-content: center; min-height: 42px; padding: 10px 18px; border-radius: 8px; border: 1px solid #b00020; font-size: 16px; font-weight: 700; cursor: pointer; text-decoration: none; }
        button { background: #b00020; color: #fff; }
        .button-link { background: #fff; color: #b00020; }
        .card { margin-top: 18px; padding: 18px; border: 1px solid #e0e0e0; border-radius: 12px; background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,.04); }
        .error { color: #b00020; font-weight: 600; }
        .douryoku-summary { margin-top: 16px; padding-top: 14px; border-top: 1px solid #eee; font-size: 30pt; color: #b00020; font-weight: 700; line-height: 1.2; }
        .muted { color: #666; font-size: 13px; }
        .table-title { font-size: 18px; font-weight: 700; margin-bottom: 10px; }
        .table-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; max-width: 100%; margin: 0 -4px; padding-bottom: 4px; }
        .douryoku-table { border-collapse: collapse; width: max-content; min-width: 100%; font-size: 14px; }
        .douryoku-table th, .douryoku-table td { border: 1px solid #ddd; padding: 6px 10px; text-align: right; }
        .douryoku-table th { background: #f5f5f5; text-align: center; font-size: 11px; line-height: 1.25; padding: 4px 5px; font-weight: 600; vertical-align: middle; }
        .douryoku-table th .th-step { font-size: 16px; font-weight: 700; line-height: 1.1; }
        .douryoku-table td:first-child, .douryoku-table td:nth-child(2), .douryoku-table td:nth-child(3), .douryoku-table td:nth-child(n+6) { text-align: center; }
        .douryoku-table tr.row-gaitou-e-high td { color: #b00020; }
        .douryoku-table td.sanchu-cell { white-space: nowrap; line-height: 1.35; }
        @media (max-width: 640px) {
            .page { padding: 20px 12px 32px; }
            h1 { font-size: 26px; }
            input[type="number"], input[type="text"] { width: 100%; }
            label { flex: 1 1 100%; }
            .actions { width: 100%; }
            button, .button-link { flex: 1; }
            .douryoku-summary { font-size: 26pt; }
        }
    </style>
</head>
<body>
<main class="page">
    <h1>動力チェック用サイト</h1>

    <form method="get" action="/" class="card">
        <div class="row">
            <label>年（西暦）
                <input type="number" name="y_inp" inputmode="numeric" min="1800" max="2200" value="<?= h($input['y_inp']) ?>">
            </label>
            <label>月
                <input type="number" name="m_inp" inputmode="numeric" min="1" max="12" value="<?= h($input['m_inp']) ?>">
            </label>
            <label>日
                <input type="number" name="d_inp" inputmode="numeric" min="1" max="31" value="<?= h($input['d_inp']) ?>">
            </label>
        </div>

        <div class="sex">
            <label><input type="radio" name="radio" value="m" <?= ($input['radio'] === 'm') ? 'checked' : '' ?>> 男</label>
            <label><input type="radio" name="radio" value="f" <?= ($input['radio'] === 'f') ? 'checked' : '' ?>> 女</label>
        </div>

        <div class="row row-names">
            <label>姓（任意）
                <input type="text" name="sei" value="<?= h($input['sei']) ?>">
            </label>
            <label>名（任意）
                <input type="text" name="mei" value="<?= h($input['mei']) ?>">
            </label>
            <div class="actions">
                <button type="submit">実行</button>
                <a class="button-link" href="/">リセット</a>
            </div>
        </div>
        <?php if ($result !== null): ?>
            <div class="douryoku-summary">動力：<?= h(implode(', ', $douryokuAges)) ?></div>
        <?php endif; ?>
    </form>

    <?php if ($error !== null): ?>
        <div class="card error">エラー: <?= h($error) ?></div>
    <?php endif; ?>

    <?php if ($result !== null): ?>
        <?php
        $step1 = $result['resultData']['douryoku_step1'] ?? [];
        ?>
        <div class="card">
            <div class="table-title">判定一覧</div>
            <?php if ($step1 !== []): ?>
                <div class="muted" style="margin-bottom: 6px;">表は横にスクロールできます</div>
                <div class="table-scroll">
                <table class="douryoku-table">
                    <thead>
                        <tr>
                            <th>年齢</th>
                            <th>干支</th>
                            <th>西暦<br>年</th>
                            <th>E値</th>
                            <th>平均との<br>差</th>
                            <th><span class="th-step">②</span>E上</th>
                            <th><span class="th-step">③</span><br>年運天中殺</th>
                            <th><span class="th-step">⑤</span><br>三合会局</th>
                            <th><span class="th-step">⑤</span>半会<br>（年運）</th>
                            <th><span class="th-step">⑤</span>半会<br>（大運）</th>
                            <th><span class="th-step">⑥</span>支合<br>（年運）</th>
                            <th><span class="th-step">⑥</span>支合<br>（大運）</th>
                            <th><span class="th-step">⑥</span>対冲<br>（年運）</th>
                            <th><span class="th-step">⑥</span>対冲<br>（大運）</th>
                            <th><span class="th-step">⑥</span>害<br>（年運）</th>
                            <th><span class="th-step">⑥</span>害<br>（大運）</th>
                            <th><span class="th-step">⑦</span>日支<br>（年運）</th>
                            <th><span class="th-step">⑦</span>日支<br>（大運）</th>
                            <th><span class="th-step">⑧</span>三柱<br>（年運、大運、<br>年運＋大運）</th>
                            <th>該当</th>
                            <th>除外</th>
                            <th>動力</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($step1 as $row): ?>
                            <?php
                            $flags = douryoku_row_flags($row);
                            $passBoth = $flags['passBoth'];
                            $gaitou = $flags['gaitou'];
                            $jogai = $flags['jogai'];
                            $highlightRow = $gaitou;
                            $isDouryoku = $flags['isDouryoku'];
                            ?>
                            <tr<?= $highlightRow ? ' class="row-gaitou-e-high"' : '' ?>>
                                <td><?= h((string)$row['age']) ?></td>
                                <td><?= h((string)($row['kanshi'] ?? '')) ?></td>
                                <td><?= h((string)$row['year']) ?></td>
                                <td><?= h((string)$row['energy']) ?></td>
                                <td><?= h((string)$row['avg_diff']) ?></td>
                                <td><?= $passBoth ? '高' : '' ?></td>
                                <td><?= h((string)($row['nenun_tenchusatsu'] ?? '')) ?></td>
                                <td><?= h((string)($row['sangou_kai'] ?? '')) ?></td>
                                <td><?= h((string)($row['hankai_nenun'] ?? '')) ?></td>
                                <td><?= h((string)($row['hankai_taiun'] ?? '')) ?></td>
                                <td><?= h((string)($row['shigou_nenun'] ?? '')) ?></td>
                                <td><?= h((string)($row['shigou_taiun'] ?? '')) ?></td>
                                <td><?= h((string)($row['taichu_nenun'] ?? '')) ?></td>
                                <td><?= h((string)($row['taichu_taiun'] ?? '')) ?></td>
                                <td><?= h((string)($row['gai_nenun'] ?? '')) ?></td>
                                <td><?= h((string)($row['gai_taiun'] ?? '')) ?></td>
                                <td><?= h((string)($row['nichi_taichu_nenun'] ?? '')) ?></td>
                                <td><?= h((string)($row['nichi_taichu_taiun'] ?? '')) ?></td>
                                <td class="sanchu-cell"><?= nl2br(h(format_sanchu_cell($row))) ?></td>
                                <td><?= $gaitou ? '該当' : '' ?></td>
                                <td><?= $jogai ? '除外' : '' ?></td>
                                <td><?= $isDouryoku ? '動力' : '' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            <?php else: ?>
                <div class="error">該当データがありません。</div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</main>
</body>
</html>

