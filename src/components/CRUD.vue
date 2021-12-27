<template>
  <div>
    <section id="first">
      <ul v-show="user_authority != 3">
        <li @click="add.open = 1">新增</li>
        <li
          @click="
            add.open = 0;
            quireItem(select_name);
          "
        >
          查詢
        </li>
        <li @click="deleteItem()">刪除</li>
        <li @click="add.open = 2">修改</li>
      </ul>
      <div id="account" v-if="user_authority == 3">
        <button @click="confirmData()">登入</button>
        <input type="text" placeholder="請輸入帳號" v-model="user.account" />
        <input type="text" placeholder="請輸入密碼" v-model="user.password" />
      </div>
      <div v-else>
        <button @click="signout()">登出</button>
      </div>
    </section>
    <section id="CRUD">
      <div class="add" v-show="add.open == 1">
        <h1>欲新增之商品內容</h1>
        <div>
          <label for="new_name">名稱</label>
          <input id="new_name" type="text" v-model="add.item.name" />
        </div>
        <div>
          <label for="new_sum">數量</label>
          <input id="new_sum" type="text" v-model="add.item.sum" />
        </div>
        <button @click="addItem()">確認新增</button>
      </div>
      <div class="search" v-show="add.open == 0">
        <input
          type="text"
          v-model="select_name"
          id="search"
          placeholder="請輸入欲查詢的商品"
        />
      </div>
      <div class="modify" v-show="add.open == 2">
        <h1>欲修改清單</h1>
        <div v-for="(item, modifyIdnex) in check" :key="modifyIdnex">
          <p>
            {{ item[1] }}名稱修改為<input
              type="text"
              v-model="item.PRODUCT_NAME"
            />
          </p>
          <p>數量修改為<input type="text" v-model="item.PRODUCT_SUM" /></p>
          <p>
            狀態:
            <select name="" id="" v-model="item.PRODUCT_STATE">
              <option value="1" :selected="item.PRODUCT_STATE == 1">
                上架
              </option>
              <option value="0" :selected="item.PRODUCT_STATE == 0">
                下架
              </option>
            </select>
          </p>
          <hr />
        </div>
        <button @click="modifyItem">確定修改</button>
      </div>
    </section>
    <section id="second">
      <h1>商品</h1>
      <div class="goods" v-for="(item, index) in goods" :key="index">
        <p>
          <input
            type="checkbox"
            name="check"
            id=""
            v-model="check"
            :value="item"
          />
          名稱:{{ item.PRODUCT_NAME }}
        </p>
        <p>數量:{{ item.PRODUCT_SUM }}</p>
        <select name="" id="" v-model="item.PRODUCT_STATE">
          <option value="1" :selected="item.PRODUCT_STATE == 1">上架</option>
          <option value="0" :selected="item.PRODUCT_STATE == 0">下架</option>
        </select>
      </div>
    </section>
  </div>
</template>

<script>
import axios from "axios";
const php_url = "./static/wasa_api/";
export default {
  name: "CRUD",
  data() {
    return {
      user_name: "",
      user_authority: 3,
      goods: [],
      select_name: "",
      check: [],
      add: {
        open: 0,
        item: {
          name: "",
          sum: "",
          state: 1,
        },
      },
      modify: 1,
      user: {
        account: "",
        password: "",
      },
    };
  },
  methods: {
    // 查詢
    quireItem(name) {
      let data = new URLSearchParams();
      let url;
      if (name == undefined || name == "") {
        url = php_url + "select.php";
      } else {
        url = php_url + "select_what.php";
        data.append("name", name);
      }
      axios({
        url,
        method: "POST",
        data,
      })
        .then((res) => {
          this.goods = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    // 刪除
    deleteItem() {
      if (this.user_authority != 1) {
        alert("權限不足");
        return;
      }
      let check = confirm("確定刪除該項目?");
      if (check == true) {
        for (let i = 0; i < this.check.length; i++) {
          let data = new URLSearchParams();
          data.append("id", this.check[i].ID);
          axios({
            url: php_url + "delete_what.php",
            method: "POST",
            data,
          })
            .then((res) => {
              if (res.data == "success") {
                alert("成功刪除");
                this.quireItem();
              }
            })
            .catch((err) => {
              console.log(err);
            });
        }
      }
    },
    // 新增
    addItem() {
      if (this.user_authority != 1 || this.user_authority != 2) {
        alert("權限不足");
        return;
      }
      let data = new URLSearchParams();
      data.append("name", this.add.item.name);
      data.append("sum", this.add.item.sum);
      axios({
        url: php_url + "add_what.php",
        method: "POST",
        data,
      })
        .then((res) => {
          if (res.data == "success") {
            alert("新增完成");
            this.quireItem();
            this.add.open = 0;
            this.add.item.name = "";
            this.add.item.sum = "";
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    // 修改
    modifyItem() {
      if (this.user_authority != 1 || this.user_authority != 2) {
        alert("權限不足");
        return;
      }
      let check = confirm("確定修改?");
      if (check == true) {
        for (let i = 0; i < this.check.length; i++) {
          let data = new URLSearchParams();
          data.append("name", this.check[i].PRODUCT_NAME);
          data.append("sum", this.check[i].PRODUCT_SUM);
          data.append("state", this.check[i].PRODUCT_STATE);
          data.append("id", this.check[i].ID);
          axios({
            url: php_url + "modify_what.php",
            data,
            method: "POST",
          })
            .then((res) => {
              if ((res.data = "success")) {
                alert("修改完成");
                this.quireItem();
                this.check = [];
                this.add.open = 0;
              }
            })
            .catch((err) => {
              console.log(err);
            });
        }
      }
    },
    // 登入
    confirmData() {
      let data = new URLSearchParams();
      data.append("account", this.user.account);
      data.append("password", this.user.password);
      axios({
        url: php_url + "confirm_member.php",
        data,
        method: "POST",
      })
        .then((res) => {
          if (res.data == "登入失敗") {
            alert(res.data);
          } else {
            alert(`登入成功,歡迎回來${res.data[0].MEMBER_NAME}`);
            this.user_name = res.data[0].MEMBER_NAME;
            this.user_authority = parseInt(res.data[0].MEMBER_POWER);
            this.user = {};
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    signout() {
      let check = confirm("確定登出?");
      if (check == true) {
        this.user_name = "";
        this.user_authority = 3;
      }
    },
  },
  mounted() {
    this.quireItem();
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
* {
  box-sizing: border-box;
}
#first {
  display: flex;
  gap: 10px;
  ul {
    flex: 1;
    display: flex;
    gap: 5px;
    list-style: none;
    margin: 0;
    padding: 0;
    li {
      border: 1px solid black;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 24px;
      border-radius: 5px;
      padding: 5px 10px;
      cursor: pointer;
      &:hover {
        background: rgba(0, 0, 0, 0.5);
        color: white;
        text-decoration: underline;
      }
      &:active {
        transform: translateY(5px);
      }
    }
  }
  button {
    font-size: 24px;
    width: 150px;
    border-radius: 5px;
    cursor: pointer;
    &:hover {
      background: gray;
      color: white;
      text-decoration: underline;
    }
    &:active {
      transform: translateY(5px);
    }
  }
}
#search {
  margin-top: 20px;
  font-size: 24px;
}
#second {
  margin-top: 50px;
}
.goods {
  display: grid;
  grid-template-columns: 4fr 4fr 1fr;
  border: 1px solid black;
}
#account {
  display: flex;
  flex-direction: column;
  gap: 5px;
}
</style>
