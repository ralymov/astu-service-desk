import Departments from 'components/employees/references/Departments.vue';
import Positions from 'components/employees/references/Positions.vue';

export default [
  {path: '/departments', component: Departments, meta: {title: 'Отделы'}},
  {path: '/positions', component: Positions, meta: {title: 'Должности'}},
];
