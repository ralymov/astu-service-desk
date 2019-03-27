import Employees from 'components/../views/employees/Employees.vue';
import Departments from 'components/../views/employees/references/Departments.vue';
import Positions from 'components/../views/employees/references/Positions.vue';

export default [
  {path: '/employees', component: Employees, meta: {title: 'Сотрудники'}},
  {path: '/departments', component: Departments, meta: {title: 'Отделы'}},
  {path: '/positions', component: Positions, meta: {title: 'Должности'}},
];
