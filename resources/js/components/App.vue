<template>
  <div :class="{'not-side': !isAuth, 'short-nav': !isOpen, 'error-page': errorPage}">
    <template v-if="!errorPage">
      <div id="header" class="d-flex align-items-center justify-content-between" v-if="isAuth">
        <div class="v-center">
          <h1 class="mr-3">{{ pageTitle }}</h1>
        </div>
        <div class="v-center">
          <div class="dropdowns">
            <b-dropdown variant="link" size="lg" no-caret right class="profile-dropdown">
              <template slot="button-content">
                <img :style="{width:'30px'}" src="/icons/user.svg">
                <span class="font-weight-bold mr-4">{{ currentUser.full_name || 'Нет данных' }}</span>
              </template>
              <b-dropdown-item href="#" @click="logout">Выход</b-dropdown-item>
            </b-dropdown>
          </div>
        </div>
      </div>
      <div id="nav" v-if="isAuth">
        <div class="nav-header d-center">
          <!--<span>ASD LOGO</span>-->
        </div>
        <div class="nav-toggle d-center" @click="navToggle">
          <img class="icon" :style="{width:'40px'}" src="/icons/left-arrow.svg" key="opened" v-if="isOpen">
          <img class="icon" :style="{width:'40px'}" src="/icons/bars.svg" key="closed" v-else>
        </div>
        <div class="nav-body">
          <ul id="nav-menu">
            <li v-for="(item,i) in menuItems" :key="i">
              <div class="menu-item-wrapper d-flex justify-content-center">
                <div class="menu-item-content">
                  <router-link :to="item.url" class="menu-link" exact>{{ item.label }}</router-link>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </template>
    <div id="content">
      <transition name="fade" mode="out-in">
        <router-view></router-view>
      </transition>
    </div>
  </div>
</template>

<script>
  import {mapActions, mapState} from 'vuex';

  export default {
    data() {
      return {
        isOpen: true,
        pageTitle: '',
        errorPage: false,
        navItems: [
          {url: '/tickets', label: 'Заявки'},
          {url: '/ticketTypes', label: 'Типы заявок'},
          {url: '/ticketStatuses', label: 'Статусы заявок'},
          {url: '/departments', label: 'Отделы'},
          {url: '/positions', label: 'Должности'},
          {url: '/employees', label: 'Сотрудники'},
          {url: '/users', label: 'Пользователи системы'},
          {url: '/user-departments', label: 'Отделы пользователей'},
          {url: '/events', label: 'Мероприятия'},
          {url: '/processors', label: 'Процессоры'},
          {url: '/ram', label: 'Оперативная память'},
          {url: '/software', label: 'Софт'},
        ],
      }
    },
    watch: {
      '$route'(to, from) {
        this.pageTitle = to.meta.title || 'Главная';
        this.errorPage = to.path === '/404';
      }
    },
    mounted() {
      if (this.isAuth) {
        this.getCurrentUser();
        this.pageTitle = this.$route.meta.title || 'Главная';
      }
      if (this.$route.path === '/404') {
        this.errorPage = true;
      }
    },
    computed: {
      ...mapState({
        isAuth: state => state.auth.auth,
        currentUser: state => state.auth.user
      }),
      menuItems() {
        switch (this.currentUser.role) {
          case 'admin':
            return [
              {url: '/tickets', label: 'Заявки'},
              {url: '/ticketTypes', label: 'Типы заявок'},
              {url: '/ticketStatuses', label: 'Статусы заявок'},
              {url: '/departments', label: 'Отделы'},
              {url: '/positions', label: 'Должности'},
              {url: '/employees', label: 'Сотрудники'},
              {url: '/users', label: 'Пользователи системы'},
              {url: '/user-departments', label: 'Отделы пользователей'},
              {url: '/events', label: 'Мероприятия'},
              {url: '/processors', label: 'Процессоры'},
              {url: '/ram', label: 'Оперативная память'},
              {url: '/software', label: 'Софт'},
            ];
          case 'contractor':
            return [
              {url: '/tickets', label: 'Заявки'},
              {url: '/events', label: 'Мероприятия'},
              {url: '/processors', label: 'Процессоры'},
              {url: '/ram', label: 'Оперативная память'},
              {url: '/software', label: 'Софт'},
            ];
          case 'department_head':
            return [
              {url: '/tickets', label: 'Заявки'},
              {url: '/events', label: 'Мероприятия'},
              {url: '/processors', label: 'Процессоры'},
              {url: '/ram', label: 'Оперативная память'},
              {url: '/software', label: 'Софт'},
            ];
        }
      }
    },
    methods: {
      ...mapActions('auth', ['setUser', 'logout']),
      navToggle() {
        this.isOpen = !this.isOpen
      },
      getCurrentUser() {
        return new Promise((resolve, reject) => {
          axios.get('/credentials')
            .then(response => {
              this.setUser(response.data);
              resolve();
            })
            .catch(error => {
              this.logout();
              reject();
            });
        });
      },
    }
  }
</script>

<style lang="scss">

  body {
    background: white;
  }

  #header {
    position: fixed;
    top: 0;
    left: 200px;
    right: 0;
    z-index: 500;
    height: 80px;
    padding: 0 25px;
    background-color: theme-color('success');
    color: white;
    transition: all 0.3s ease-out;

    h1 {
      font-size: 28px;
    }

    .icon {
      width: 30px;
      height: 32px;
      color: white;
    }

    .dropdown {
      .btn {
        min-width: auto;
      }
    }

  }

  #nav {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    z-index: 100;
    width: 200px;
    background-color: #2e3642;
    color: white;
    transition: all 0.3s ease-out;

    .nav-toggle {
      position: absolute;
      right: 0;
      top: 0;
      width: 80px;
      height: 80px;
      background-color: darken(theme-color('success'), 20%);
      cursor: pointer;
      text-align: center;

      .icon {
        width: 35px;
        height: inherit;
      }
    }

    .nav-header {
      height: 80px;
      padding-right: 80px;
    }
  }

  #content {
    padding: 100px 20px 20px;
    margin-left: 200px;
  }

  .not-side {
    #content {
      margin-left: 0;
    }
  }

  .error-page {
    #content {
      margin-left: 0;
      padding: 0;
    }
  }

  #nav-menu {
    height: 900px;
    overflow-y: auto;
    margin-top: 50px;

    &, & ul {
      list-style: none;
      padding-left: 0;
    }

    > li {
      // 2 level
      > div > div > ul {
        margin-top: 10px;
        padding-left: 30px;
        border-left: 1px solid #a1a1a1;
        list-style-type: disc;
        color: #00c690;

        div {
          color: #a1a1a1;
        }

        // 3 level
        ul {
          margin: 3px 0 5px 12px;
          padding-left: 10px;
          border-left: 1px solid #a1a1a1;
        }
      }
    }
  }

  .short-nav {
    #header {
      left: 80px;
    }

    #nav {
      width: 80px;

      .nav-header {
        height: 80px;
        padding-right: 0px;
      }

      .nav-toggle {
        position: static;
      }
    }

    #content {
      margin-left: 80px;
    }

    #nav-menu {
      > li > .menu-item-wrapper {
        &:hover {
          > .menu-item-content {
            display: block;
          }
        }

        > .menu-icon {
          height: 60px;
          width: 100%;
        }

        > .menu-item-content {
          position: absolute;
          left: 80px;
          display: none;
          min-width: 200px;
          padding: 20px;
          background-color: #1e242c;
        }
      }
    }
  }

  .menu-item-wrapper {
    position: relative;
    margin-top: 10px;
  }

  .menu-icon {
    width: 55px;
    height: 50px;

    + div {
      padding-top: 13px;
    }
  }

  .menu-link {
    cursor: pointer;
    color: #a1a1a1;
    white-space: nowrap;
    text-decoration: none !important;

    &:hover, &.active {
      color: #00c690 !important;
    }
  }

  .profile-dropdown {
    .btn-link {
      color: white;
      text-decoration: none;

      &:hover {
        text-decoration: none;
      }

      &:focus {
        text-decoration: none;
      }
    }
  }

  .fade-enter {
    opacity: 0;
  }

  .fade-enter-active {
    transition: opacity .3s ease;
  }

  .fade-leave {
  }

  .fade-leave-active {
    transition: opacity .3s ease;
    opacity: 0;
  }

</style>
