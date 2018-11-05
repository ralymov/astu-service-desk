import TicketsList from 'components/tickets/TicketsList.vue';
import TicketTypes from 'components/tickets/references/TicketTypes.vue';
import TicketStatuses from 'components/tickets/references/TicketStatuses.vue';

export default [
  {path: '/tickets', component: TicketsList, meta: {title: 'Заявки'}},
  {path: '/ticketTypes', component: TicketTypes, meta: {title: 'Типы заявок'}},
  {path: '/ticketStatuses', component: TicketStatuses, meta: {title: 'Статусы заявок'}},
];
