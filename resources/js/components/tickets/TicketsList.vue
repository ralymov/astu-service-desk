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

      <template slot="customer" slot-scope="data">
        {{ _.get(data.item, 'applicant.name', data.item.applicant_name) }}
      </template>
      <template slot="contractor" slot-scope="data">
        {{ _.get(data.item, 'contractor.name', 'Нет данных') }}
      </template>
      <template slot="status" slot-scope="data">
        <div class="badge badge-primary status-badge"
             :style="{ 'background-color': _.get(data.item, 'status.rgb') }">
          {{ _.get(data.item, 'status.name', 'Нет данных') }}
        </div>
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

  export default {
    name: "TicketsList",
    components: {
      TicketCreate,
    },
    data() {
      return {
        tickets: [],
        fields: [
          {
            key: 'id',
            label: '№',
            sortable: false,
          },
          {
            key: 'title',
            label: 'Тема',
            sortable: false,
          },
          {
            key: 'customer',
            label: 'Клиент',
            sortable: false,
          },
          {
            key: 'contractor',
            label: 'Ответственный',
            sortable: false,
          },
          {
            key: 'status',
            label: 'Статус',
            sortable: false,
          },
        ],
      }
    },
    mounted() {
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
        console.log('middle click');
        let routeData = this.$router.resolve('/tickets/edit/' + item.id);
        window.open(routeData.href, '_blank');
      },
      changePage() {
        this.fetchData(this.tickets.current_page);
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