<template>
  <b-card header-tag="header"
          footer-tag="footer"
          class="user-card">

    <h4 slot="header" class="mb-0">Новый пользователь</h4>

    <b-form @submit.prevent="storeOrUpdate" id="userCreateForm">
      <b-container fluid>

        <b-row class="my-1">
          <b-col sm="3">
            <label for="inputName">ФИО:</label>
          </b-col>
          <b-col sm="9">
            <b-form-input id="inputName" v-model="user.name" required></b-form-input>
          </b-col>
        </b-row>

        <b-row class="mt-4">
          <b-col sm="3">
            <label for="inputLogin">Логин:</label>
          </b-col>
          <b-col sm="9">
            <b-form-input id="inputLogin" v-model="user.username" required></b-form-input>
          </b-col>
        </b-row>

        <b-row class="mt-4">
          <b-col sm="3">
            <label for="inputPassword">Пароль:</label>
          </b-col>
          <b-col sm="9">
            <b-form-input id="inputPassword" v-model="user.password" type="password" required></b-form-input>
          </b-col>
        </b-row>

        <b-row class="mt-4">
          <b-col sm="3">
            <label for="inputEmail">E-mail:</label>
          </b-col>
          <b-col sm="9">
            <b-form-input id="inputEmail" v-model="user.email"></b-form-input>
          </b-col>
        </b-row>

        <b-row class="mt-4">
          <b-col sm="3">
            <label for="inputDepartment">Отдел:</label>
          </b-col>
          <b-col sm="9">
            <select-search id="inputDepartment"
                           v-model="user.department_id"
                           searchTable="departments"
                           searchField="name">
            </select-search>
          </b-col>
        </b-row>

        <b-row class="mt-4">
          <b-col sm="3">
            <label for="inputPosition">Должность:</label>
          </b-col>
          <b-col sm="9">
            <select-search id="inputPosition"
                           v-model="user.position_id"
                           searchTable="positions"
                           searchField="name">
            </select-search>
          </b-col>
        </b-row>

      </b-container>
    </b-form>

    <div slot="footer">
      <b-button variant="success" type="submit" class="mr-1" form="userCreateForm">
        Сохранить
      </b-button>
    </div>

  </b-card>
</template>

<script>

  export default {
    name: "UserCreate",
    data() {
      return {
        user: {},
        departments: [],
      }
    },
    mounted() {
      this.fetchReferences();
      this.fetchData();
    },
    methods: {
      fetchData() {
        if (!this.$route.params.id) return;
        axios.get('users/' + this.$route.params.id)
          .then(response => this.user = response.data);
      },
      fetchReferences() {
        axios.get('departments')
          .then(response => this.departments = response.data);
      },
      storeOrUpdate() {
        if (!this.$route.params.id) {
          this.store();
        } else {
          this.update();
        }
      },
      store() {
        axios.post('users', this.user)
          .then(response => {
            this.alertSuccess();
            this.$router.push('/users');
          });
      },
      update() {
        axios.put('users/' + this.$route.params.id, this.user)
          .then(response => this.alertSuccess());
      }
    }
  }
</script>

<style scoped>
  .user-card {
    width: 60%;
  }
</style>
