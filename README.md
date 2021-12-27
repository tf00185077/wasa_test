# test

> A Vue.js project

## Build Setup

```bash
# install dependencies
npm install

# serve with hot reload at localhost:8080
npm run dev

# build for production with minification
npm run build

# build for production and view the bundle analyzer report
npm run build --report
```

以 php 對 mySQL 做資料串接<br>
一開始畫面為全部商品，若沒有登入則不能做任何修改<br>
登入後分兩種權限，一種為最高級，可以做包含刪除在內所有動作<br>
而第二種權限為能做不包含刪除的另外三樣，新增查詢或是修改<br>
將四項功能放在畫面最上層，讓使用者可以不論在何種位置皆能使用四項功能<br>
且新增修改或查詢一次只會顯示一個功能，防止使用者忘記當下是在做哪一種動作<br>
並且動作前都有確認視窗以防錯誤操作。
