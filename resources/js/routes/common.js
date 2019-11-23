import Home from 'components/auth/Home.vue';
import UsersList from 'views/users/UsersList.vue';
import UserCreate from 'views/users/User.vue';
import UserDepartments from "views/users/references/UserDepartments";
import TicketsList from "views/tickets/TicketsList";
import Profile from "components/auth/Profile";

export default [
  {path: '/', component: TicketsList, meta: {title: 'Профиль'}},
  {path: '/profile', component: Profile, meta: {title: 'Заявки'}},
  {path: '/users', component: UsersList, meta: {title: 'Пользователи'}},
  {path: '/users/create', component: UserCreate, meta: {title: 'Создание пользователя'}},
  {path: '/users/edit/:id', component: UserCreate, meta: {title: 'Редактирование пользователя'}},
  {path: '/user-departments', component: UserDepartments, meta: {title: 'Отделы пользователей'}},
];
