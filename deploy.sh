#!/bin/bash

# プロジェクトディレクトリに移動
cd ~/tech/coachtechflemarket

# 最新のコードを取得
git pull origin develop

# Dockerコンテナを停止して削除
docker-compose down

# Dockerコンテナを再起動
docker-compose up -d --build
