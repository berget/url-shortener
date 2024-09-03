# url-shortener

# 短網址系統

### 系統架構概述
縮網址系統的核心目標是將長網址轉換為短網址，並允許使用者通過短網址重定向到原始長網址。我們將通過 Laravel 的框架 結構來實現這一目標。
### 1. 資料表設計
#### 表結構定義
表名: short_urls
- id: 自增主鍵 ( BIGINT UNSIGNED AUTO_INCREMENT) – 唯一標識每條記錄。
- original_url: 長網址 ( VARCHAR(2048)) – 用於存儲原始的長網址。
- short_code: 短網址代碼 ( CHAR(6)) – 儲存生成的短網址，長度設為固定的6個字符，這樣可容納的唯一組合足以支撐常見的應用需求。
- created_at: 創建時間 ( TIMESTAMP) – 自動生成。
- updated_at: 更新時間 ( TIMESTAMP) – 自動生成。
#### 索引設置
- 唯一索引: 為 original_url 設置唯一索引，避免相同長網址重複存儲。
- 普通索引: 為 short_code 設置索引，以加快短網址查詢的速度。

#### 2. API 設計
API 設計將遵循 RESTful 標準，具體包括以下幾個端點。
#### POST /api/shorten
- 功能: 接收用戶提交的長網址，生成並返回相應的短網址。
- 請求 Body:
    - url (string, 必需): 用戶提交的長網址，需通過後端進行驗證，確保其格式正確。
- 回應:
    - 成功: 返回 200 OK，並在 JSON 中包含 short_url（短網址）。
    - 失敗: 如果 url 格式不正確或超出長度限制，返回 400 Bad Request，並在 JSON 中給出錯誤信息。
#### GET /api/{short_code}
- 功能: 通過短網址查詢對應的長網址，並重定向到該長網址。
- 路由參數:
    - {short_code} (string, 必需): 短網址代碼，需通過正則表達式驗證，確保其格式正確。
- 回應:
    - 成功: 返回 302 Found，並重定向到 original_url。
    - 失敗: 如果未找到對應的短網址，返回 404 Not Found。
#### GET /api/lookup/{short_code}
- 功能: 提供反查短網址對應的長網址功能。
- 路由參數:
    - {short_code} (string, 必需): 短網址代碼。
- 回應:
    - 成功: 返回 200 OK，並在 JSON 中包含 original_url。
    - 失敗: 如果未找到對應的長網址，返回 404 Not Found。
#### 3. 核心邏輯
縮網址系統的核心邏輯涉及以下幾個重要部分：
- 短網址生成邏輯:
    - 系統將接收用戶的長網址，檢查其是否已存在於數據庫中。如果存在，直接返回已存在的短網址。如果不存在，則生成一個唯一的短網址代碼並儲存到數據庫中。
- 短網址查詢與重定向:
    - 當用戶通過短網址訪問系統時，系統將根據短網址代碼查找對應的長網址，並進行 HTTP 重定向。
- 反查邏輯:
    - 允許用戶通過 API 查詢短網址對應的長網址，這對於用戶管理生成的縮網址有很大的幫助。
#### 4. 核心組件
- Controller (控制器)： 負責接收HTTP請求，處理業務邏輯，並返回響應。
- Service (服務層)： 集中業務邏輯的處理，使控制器保持簡潔。
- Repository (數據層)： 負責與數據庫進行交互，封裝Eloquent的操作。
- Model (模型)： 代表數據庫中的表，與數據庫進行ORM層面的互動。

#### 5. 緩存與性能優化
為了支持高併發和快速響應，我們計劃引入 Redis 來緩存常用的短網址和長網址映射。這樣可以大幅度減少對數據庫的查詢次數，提高系統的整體性能。
- Redis 緩存策略:
    - 每次創建或查詢短網址時，將其對應關係緩存在 Redis 中，設置適當的過期時間。
    - 緩存命中時直接返回結果，未命中時再查詢數據庫並更新緩存。

# 縮網址系統實作 TODO 列表

## 1. 資料庫設計與實作

- [ ] 設計並創建 `short_urls` 資料表
    - [ ] 定義表結構 (`id`, `original_url`, `short_code`, `created_at`, `updated_at`)
    - [ ] 設置 `original_url` 的唯一索引
    - [ ] 設置 `short_code` 的索引

## 2. API 設計與開發

### 2.1 短網址生成 API (POST /api/shorten)
- [ ] 設計 API 端點
- [ ] 實作短網址生成邏輯
- [ ] 完成 URL 格式驗證
- [ ] 返回短網址至 JSON

### 2.2 短網址重定向 API (GET /api/{short_code})
- [ ] 設計 API 端點
- [ ] 實作短網址查詢與重定向邏輯
- [ ] 實現 302 重定向至原始 URL

### 2.3 反查短網址 API (GET /api/lookup/{short_code})
- [ ] 設計 API 端點
- [ ] 實作短網址反查邏輯
- [ ] 返回原始 URL 至 JSON

## 3. 核心邏輯與業務處理

- [ ] 設計並實作短網址生成邏輯
    - [ ] 長網址是否已存在檢查
    - [ ] 生成唯一短網址代碼
- [ ] 設計並實作短網址查詢與重定向邏輯
- [ ] 設計並實作短網址反查邏輯

## 4. 核心組件開發

- [ ] 創建必要的控制器 (Controllers)
- [ ] 創建並實作服務層 (Services) 以處理業務邏輯
- [ ] 創建並實作數據層 (Repositories) 以進行數據庫交互

## 5. 緩存與性能優化

- [ ] 設計並實作 Redis 緩存策略
    - [ ] 設置短網址與長網址的緩存邏輯
    - [ ] 實現查詢時的緩存命中檢查與更新

## 6. 測試與驗證

- [ ] 編寫單元測試覆蓋主要業務邏輯
- [ ] 測試 API 的正確性與性能
- [ ] 驗證 Redis 緩存的有效性
