import TicketsList from 'views/tickets/TicketsList.vue';
import TicketTypes from 'views/tickets/references/TicketTypes.vue';
import TicketStatuses from 'views/tickets/references/TicketStatuses.vue';
import TicketEdit from 'views/tickets/TicketEdit.vue';

export default [
  {path: '/tickets', component: TicketsList, meta: {title: 'Заявки'}},
  {path: '/tickets/edit/:id', component: TicketEdit, meta: {title: 'Редактирование заявки'}},
  {path: '/ticketTypes', component: TicketTypes, meta: {title: 'Типы заявок'}},
  {path: '/ticketStatuses', component: TicketStatuses, meta: {title: 'Статусы заявок'}},
];
