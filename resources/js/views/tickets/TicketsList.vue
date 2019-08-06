<template>
  <div>

    <b-button variant="success" v-b-modal.ticketCreate>Создать заявку</b-button>
    <ticket-create @ticketCreated="ticketCreated"></ticket-create>

    <b-table class="mt-4"
             hover :items="tickets.data"
             :fields="fields"
             tbody-tr-class="pointer"
             @row-clicked="editTicket"
             @row-middle-clicked="editTicketNewPage">

      <template slot="HEAD_priority" slot-scope="data">
        <v-icon name="info-circle" id="priority-column-header"/>
        <b-tooltip target="priority-column-header" title="Приоритет"/>
      </template>

      <template slot="priority" slot-scope="data">
        <div v-if="data.item.priority.code==='high'" v-b-tooltip.hover title="Высокий приоритет">
          <v-icon name="arrow-circle-up" style="color:red;"/>
        </div>
        <div v-else-if="data.item.priority.code==='normal'" v-b-tooltip.hover title="Обычный приоритет">
          <v-icon name="minus-circle" style="color:blue;"/>
        </div>
        <div v-else v-b-tooltip.hover title="Низкий приоритет">
          <v-icon name="arrow-circle-down" style="color:blue;"/>
        </div>
      </template>

      <template slot="customer" slot-scope="data">
        {{ _.get(data.item, 'applicant.name', data.item.applicant_name) }}
      </template>

      <template slot="contractor" slot-scope="data">
        {{ _.get(data.item, 'contractor.name') || _.get(data.item, 'department.name') || 'Нет данных' }}
      </template>

      <template slot="cabinet" slot-scope="data">
        {{ _.get(data.item, 'applicant.cabinet') }}
      </template>

      <template slot="created_at" slot-scope="data">
        {{ data.item.created_at | ui-normalize-date }}
      </template>

      <template slot="days_passed" slot-scope="data">
        {{ diffInDays(data.item.created_at) + ' дн.' }}
      </template>

      <template slot="author" slot-scope="data">
        {{ _.get(data.item, 'author.name') }}
      </template>

      <template slot="status" slot-scope="data">
        <div class="badge badge-primary status-badge"
             :style="{ 'background-color': _.get(data.item, 'status.rgb') }">
          {{ _.get(data.item, 'status.name', 'Нет данных') }}
        </div>
      </template>

      <template slot="actions" slot-scope="data">
        <b-button v-if="data.item.contractor_id"
                  variant="warning" size="sm"
                  v-b-tooltip.hover title="Разблокировать"
                  @click="unlock(data.item)">
          <v-icon name="lock-open"/>
        </b-button>
        <b-button v-else variant="warning" size="sm"
                  v-b-tooltip.hover title="Заблокировать"
                  @click="lock(data.item)">
          <v-icon name="lock"/>
        </b-button>

        <b-button v-if="!data.item.closed_at" variant="success" size="sm"
                  v-b-tooltip.hover title="Выполнить"
                  @click="complete(data.item)">
          <v-icon name="check"/>
        </b-button>
      </template>

    </b-table>

    <b-pagination size="md"
                  :total-rows="tickets.total"
                  v-model="tickets.current_page"
                  :per-page="tickets.per_page"
                  @input="changePage">
    </b-pagination>

  </div>
</template>

<script>
  import TicketCreate from './TicketCreate';
  import ticketApi from "api/tickets/ticketApi";

  export default {
    name: "TicketsList",
    components: {
      TicketCreate,
    },
    data() {
      return {
        tickets: {
          total: 0,
          current_page: 1,
          per_page: 20,
          data: []
        },
        fields: [
          {
            key: 'id',
            label: '#',
            sortable: false,
          },
          {
            key: 'priority',
            label: 'Приоритет',
            sortable: false,
          },
          {
            key: 'customer',
            label: 'Заявитель',
            sortable: false,
          },
          {
            key: 'title',
            label: 'Тема',
            sortable: false,
          },
          {
            key: 'description',
            label: 'Суть заявки',
            sortable: false,
          },
          {
            key: 'cabinet',
            label: 'Аудитория',
            sortable: false,
          },
          {
            key: 'created_at',
            label: 'Создано',
            sortable: false,
          },
          {
            key: 'days_passed',
            label: 'Прошло',
            sortable: false,
          },
          {
            key: 'author',
            label: 'Автор',
            sortable: false,
          },
          {
            key: 'contractor',
            label: 'Исполнитель',
            sortable: false,
          },
          {
            key: 'status',
            label: 'Статус',
            sortable: false,
          },
          {
            key: 'actions',
            label: 'Действия',
            sortable: false,
          },
        ],
      }
    },
    created() {
      this.fetchData();
    },
    methods: {
      fetchData(page = 1) {
        axios.get('tickets/?page=' + page)
          .then(response => this.tickets = response.data)
      },
      ticketCreated(ticket) {
        this.tickets.data.unshift(ticket);
      },
      editTicket(item) {
        this.$router.push('/tickets/edit/' + item.id);
      },
      editTicketNewPage(item) {
        let routeData = this.$router.resolve('/tickets/edit/' + item.id);
        window.open(routeData.href, '_blank');
      },
      changePage() {
        this.fetchData(this.tickets.current_page);
      },

      async lock(ticket) {
        ticket = await ticketApi.lock(ticket.id);
        this.updateById(this.tickets.data, ticket.id, ticket);
      },
      async unlock(ticket) {
        ticket = await ticketApi.unlock(ticket.id);
        console.log(ticket);
        this.updateById(this.tickets.data, ticket.id, ticket);
      },
      async complete(ticket) {
        ticket = await ticketApi.complete(ticket.id);
        this.updateById(this.tickets.data, ticket.id, ticket);
      },
      async cancelComplete(ticket) {
        ticket = await ticketApi.cancelComplete(ticket.id);
        this.updateById(this.tickets.data, ticket.id, ticket);
      },
    }
  }
</script>

<style lang="scss">
  .table .status-badge {
    min-width: 100px;
    font-size: 16px;
    cursor: pointer;

    &:hover {
      filter: brightness(85%);
    }
  }
</style>
