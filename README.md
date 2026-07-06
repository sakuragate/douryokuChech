# 動力チェック（douryokuCheck）

四柱推命の動力判定をローカル／WEBで確認するための PHP アプリです。

## ファイル構成

| ファイル | 説明 |
|---------|------|
| `index.php` | 入力フォーム・動力テーブル表示 |
| `ArithmeticScienceClass.php` | 命式・動力の計算ロジック |

## ローカルで確認する

PHP 8.1 以上が必要です。

```bash
git clone https://github.com/sakuragate/douryokuChech.git
cd douryokuChech
php -S localhost:8080
```

ブラウザで http://localhost:8080 を開いてください。

## WEBで確認する（おすすめ）

**GitHub だけでは PHP は動きません**（GitHub Pages は静的サイト専用のため）。

コードはこのリポジトリで管理し、WEB公開は [Render](https://render.com) が手軽です（無料プランあり）。

### Render でのデプロイ手順

1. [Render](https://render.com) に GitHub アカウントでサインアップ
2. **New → Blueprint** を選択
3. このリポジトリ `sakuragate/douryokuChech` を接続
4. `render.yaml` を読み込んで **Apply** をクリック
5. デプロイ完了後、表示された URL（例: `https://douryoku-check.onrender.com`）にアクセス

`render.yaml` と `Dockerfile` はリポジトリに含まれています。

## 検証用の正解例

| 生年月日 | 動力（年齢） |
|---------|-------------|
| 1972年3月17日（Yさん） | 20, 46, 52, 53, 68 |
| 1982年1月25日（Hさん） | 40, 52, 55, 64 |
