<template>
  <div>

    <b-button variant="success" @click="createEvent">Запланировать мероприятие</b-button>

    <b-table class="mt-4"
             hover :items="events.data"
             :fields="fields"
             tbody-tr-class="pointer"
             @row-clicked="editEvent"
             @row-middle-clicked="editEventNewPage">
    </b-table>

    <b-pagination size="md"
                  :total-rows="events.total"
                  v-model="events.current_page"
                  :per-page="events.per_page"
                  @input="changePage">
    </b-pagination>

  </div>
</template>

<script>
  import eventApi from "api/tickets/eventApi";

  export default {
    name: "TicketsList",
    components: {},
    data() {
      return {
        events: [],
        fields: [
          {
            key: 'name',
            label: 'Название',
            sortable: false,
          },
          {
            key: 'date',
            label: 'Дата',
            sortable: false,
          },
          {
            key: 'computers_number',
            label: 'Количество компьютеров',
            sortable: false,
          },
          {
            key: 'estimated_time',
            label: 'Предполагаемое время выполнения, мин.',
            sortable: false,
          },
          {
            key: 'real_time',
            label: 'Реальное время выполнения, мин.',
            sortable: false,
          },
        ],
      }
    },
    created() {
      this.fetchData();
    },
    methods: {
      async fetchData(page = 1) {
        this.events = await eventApi.get(page);
      },
      createEvent() {
        this.$router.push('/events/create');
      },
      editEvent(item) {
        this.$router.push('/events/edit/' + item.id);
      },
      editEventNewPage(item) {
        let routeData = this.$router.resolve('/events/edit/' + item.id);
        window.open(routeData.href, '_blank');
      },
      changePage() {
        this.fetchData(this.events.current_page);
      },
    }
  }
</script>