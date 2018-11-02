<template>
  <div>

    <b-button variant="success" v-b-modal.ticketCreate>Создать заявку</b-button>
    <ticket-create @ticketCreated="ticketCreated"></ticket-create>

    <b-table class="mt-4"
             hover :items="tickets.data"
             :fields="fields"
             tbody-tr-class="pointer"
             @row-clicked="editTicket">

      <template slot="customer" slot-scope="data">
        {{ _.get(data.item, 'applicant.name', data.item.applicant_name) }}
      </template>
      <template slot="contractor" slot-scope="data">
        {{ _.get(data.item, 'employee.name', 'Нет данных') }}
      </template>
      <template slot="status" slot-scope="data">
        <div class="badge badge-primary status-badge"
             :style="{ 'background-color': _.get(data.item, 'status.rgb', '#fff') }">
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
      editTicket(id) {
        console.log('Edit ticket ' + id);
      },
      changePage() {
        this.fetchData(this.tickets.current_page);
      },
    }
  }
</script>

<style lang="scss" scoped>

</style>