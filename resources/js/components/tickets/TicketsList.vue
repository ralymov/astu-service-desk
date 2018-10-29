<template>
  <div>

    <b-table hover :items="tickets.data" :fields="fields">
      <template slot="customer" slot-scope="data">
        {{ _.get(data.item, 'applicant.name', data.item.applicant_name) }}
      </template>
      <template slot="contractor" slot-scope="data">
        {{ _.get(data.item, 'employee.name', 'Нет данных') }}
      </template>
      <template slot="status" slot-scope="data">
        {{ data.item.status ? data.item.status.name : 'Нет данных' }}
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
  export default {
    data() {
      return {
        tickets: [],
        fields: [
          {
            key: 'id',
            label: '№',
            sortable: true,
          },
          {
            key: 'title',
            label: 'Тема',
            sortable: true,
          },
          {
            key: 'customer',
            label: 'Клиент',
            sortable: true,
          },
          {
            key: 'contractor',
            label: 'Ответственный',
            sortable: true,
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
      changePage() {
        this.fetchData(this.tickets.current_page);
      }
    }
  }
</script>

<style lang="scss" scoped>

</style>