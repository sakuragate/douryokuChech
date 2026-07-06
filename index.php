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
    <title>ArithmeticScienceClass テスト</title>
    <style>
        body { font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif; line-height: 1.4; margin: 24px; }
        .row { display: flex; gap: 12px; flex-wrap: wrap; align-items: end; }
        .row-names { align-items: start; }
        label { display: grid; gap: 6px; font-size: 14px; }
        input[type="number"], input[type="text"] { padding: 8px 10px; font-size: 16px; width: 10rem; }
        .sex { display: flex; gap: 12px; padding: 8px 0; }
        button { padding: 10px 14px; font-size: 16px; cursor: pointer; }
        .card { margin-top: 18px; padding: 14px; border: 1px solid #ddd; border-radius: 10px; }
        .error { color: #b00020; font-weight: 600; }
        .douryoku-summary { margin-top: 8px; font-size: 30pt; color: #b00020; font-weight: 600; }
        pre { white-space: pre-wrap; word-break: break-word; }
        .muted { color: #666; font-size: 13px; }
        .table-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; max-width: 100%; margin: 0 -4px; padding-bottom: 4px; }
        .douryoku-table { border-collapse: collapse; width: max-content; min-width: 100%; font-size: 14px; }
        .douryoku-table th, .douryoku-table td { border: 1px solid #ddd; padding: 6px 10px; text-align: right; }
        .douryoku-table th { background: #f5f5f5; text-align: center; font-size: 11px; line-height: 1.25; padding: 4px 5px; font-weight: 600; vertical-align: middle; }
        .douryoku-table th .th-step { font-size: 16px; font-weight: 700; line-height: 1.1; }
        .douryoku-table td:first-child, .douryoku-table td:nth-child(2), .douryoku-table td:nth-child(3), .douryoku-table td:nth-child(n+6) { text-align: center; }
        .douryoku-table tr.row-gaitou-e-high td { color: #b00020; }
        .douryoku-table td.sanchu-cell { white-space: nowrap; line-height: 1.35; }
    </style>
</head>
<body>
    <h1>ArithmeticScienceClass テスト</h1>
    <div class="muted">このページはローカル検証用の簡易UIです（Laravel不要）。</div>

    <form method="get" class="card">
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
            <button type="submit">実行</button>
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
        $step2Count = 0;
        foreach ($step1 as $row) {
            if (($row['avg_diff'] ?? 0) > 0) {
                $step2Count++;
            }
        }
        ?>
        <div class="card">
            <div style="font-weight: 700; margin-bottom: 8px;">動力 ①②（20〜70歳 / 平均より高い）</div>
            <div class="muted" style="margin-bottom: 10px;">
                ① 1〜19歳・71歳〜を除く → <?= count($step1) ?> 件（年齢 <?= h((string)($step1[0]['age'] ?? '')) ?> 〜 <?= h((string)($step1[count($step1) - 1]['age'] ?? '')) ?> 歳）<br>
                ② 平均より高い年 → <?= $step2Count ?> 件（「エネルギー上」= 高）
            </div>
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

        <div class="card">
            <div style="font-weight: 700; margin-bottom: 8px;">結果（var_dump）</div>
            <pre><?php var_dump($result); ?></pre>
        </div>
        <div class="card">
            <div style="font-weight: 700; margin-bottom: 8px;">結果（JSON）</div>
            <pre><?= h(json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?: '') ?></pre>
        </div>
    <?php endif; ?>
</body>
</html>

