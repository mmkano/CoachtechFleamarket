# coachtechフリマ (フリマアプリ)
coachtechフリマは、coachtechブランドのアイテムを出品および購入するための独自のフリマアプリです。<br>このアプリはユーザーが簡単に商品を出品し、興味のある商品を検索・購入できるプラットフォームを提供します。スマートフォンやPCを利用して、どこからでも簡単にアクセスできるように設計されています。


## 作成した目的  
coachtechフリマを作成した目的は、coachtechブランドのアイテムを手軽に売買できる専用のプラットフォームを提供することです。<br>従来の競合他社のフリマアプリが複雑で使いにくいと感じているユーザーに対して、より使いやすく直感的なインターフェースを提供することで、ブランドのファン層を拡大し、初年度でのユーザー数1000人達成を目指します。さらに、このアプリを通じて、coachtechブランドの認知度を高め、ユーザーにとって価値のあるマーケットプレイスを構築することが目的です。


## アプリケーションURL    

### AWS（開発環境）  
* http://54.238.177.166/login (ユーザーURL)
* http://54.238.177.166/admin/login (管理者URL)
* mailhog:http://54.238.177.166:8025/  

### AWS(本番環境）  
* http://52.68.190.137/login (ユーザーURL)
* http://52.68.190.137/admin/login (管理者URL)
* mailhog：http://52.68.190.137:8026/

#### ユーザー用URLの使用方法
* ユーザーは会員登録後、ログインします。初回ログイン時にはプロフィール編集ページに遷移し、ユーザー名を登録できます。<br>2回目以降は通常通りトップページに遷移します。ユーザー名を登録しない場合、登録時のメールアドレスがユーザー名として表示されます。<br>ログイン後、商品一覧や詳細ページで商品の説明、カテゴリー、状態を確認でき、コメントアイコンをクリックすることでコメントの閲覧や投稿が可能です。購入ページではクレジットカード、銀行振り込み、コンビニ払いの選択肢があり、住所未登録の場合はプロフィール画面で住所を登録した後に再度購入手続きを行います。トップページの検索バーを利用して商品検索も行え、商品の出品も可能です。

#### 管理者URLの使用方法
* 管理者は、管理者専用のメールアドレスとパスワードを使用してログインします。<br>ログイン後、ユーザー一覧ページに遷移し、各ユーザーの詳細ボタンを押すことで、そのユーザーのコメント削除、アカウント削除、メール送信などの管理操作を行うことができます。

## 機能一覧

### User
* 会員登録
* ログイン
* ログアウト
* 商品検索（商品名、商品説明、カテゴリー、ブランド、商品状態）
* お気に入り機能(追加・削除)
* コメント機能(追加・削除)
* お支払い変更
* 配送先変更機能
* プロフィール変更
* 出品
* 購入機能
* 決済機能
  
##### 補足事項
* コンビニ払いや銀行振り込みを選択された場合、お支払い情報がメールで送信されるように設定されています。


### Admin
* ユーザー一覧取得
* ユーザーのコメント削除
* ユーザーのアカウント削除
* メール送信

	
## 使用技術
* PHP7.4.9
* Laravel8.83.27 
* HTML,CSS  
* MySQL8.0.26    
* NGINX1.21.1  
* MAILHOG  
* PHPMyADMIN  


## テーブル設計  
![スクリーンショット 2024-07-27 19 59 06](https://github.com/user-attachments/assets/8bbdea64-2b6a-4873-94f4-cee86f99937e)
![スクリーンショット 2024-07-27 19 59 24](https://github.com/user-attachments/assets/503d7720-efb0-4c16-867f-d56ee891cd65)
![スクリーンショット 2024-07-27 19 59 35](https://github.com/user-attachments/assets/416a07fb-6b73-4b81-af9a-f076abafc00b)


## ER図  
![er1 drawio](https://github.com/user-attachments/assets/89393454-ed22-42c3-acce-86c0fe3b6acf)


## 環境構築  

**Dockerビルド**  
1.`git clone git@github.com:mmkano/CoachtechFleamarket.git`  
2.DockerDesktopアプリを立ち上げる  
3.`docker-compose up -d --build`    
4.「.env.example」ファイルを 「.env」ファイルに命名を変更。または、新しく.envファイルを作成  
5..envに以下の環境変数を追加  
 ```bash
DB_CONNECTION=mysql      
DB_HOST=mysql    
DB_PORT=3306
DB_DATABASE=laravel_db  
DB_USERNAME=laravel_user   
DB_PASSWORD=laravel_pass
```    
6.アプリケーションキーの作成  
``` bash 
php artisan key:generate
```   
7.マイグレーションの実行  
```bash
php artisan migrate
```  
8.シーディングの実行 
``` bash
php artisan db:seed 
```     

## PHPUnitテスト実行コマンド
* すべてのテストを実行するには、以下のコマンドを使用します。<br>
``` bash
./vendor/bin/phpunit
```
* 特定のテストファイルを実行するには、ファイル名を指定します。<br>
``` bash
./vendor/bin/phpunit tests/Feature/ItemControllerTest.php
```


#### テストユーザー
* email:admin@example.com  password:password (管理者ログイン用)
* email:test@example.com password:password (ユーザーログイン用)


