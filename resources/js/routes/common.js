import Home from 'components/auth/Home.vue';
import UsersList from 'views/users/UsersList.vue';
import UserCreate from 'views/users/User.vue';
import UserDepartments from "views/users/references/UserDepartments";

export default [
  {path: '/', component: Home, meta: {title: 'Главная'}},
  {path: '/users', component: UsersList, meta: {title: 'Пользователи'}},
  {path: '/users/create', component: UserCreate, meta: {title: 'Создание пользователя'}},
  {path: '/users/edit/:id', component: UserCreate, meta: {title: 'Редактирование пользователя'}},
  {path: '/user-departments', component: UserDepartments, meta: {title: 'Отделы пользователей'}},
];
