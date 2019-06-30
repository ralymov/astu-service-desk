<template>
  <b-card header-tag="header"
          footer-tag="footer"
          class="event-card">

    <h4 slot="header" class="mb-0">Новое мероприятия</h4>

    <b-form @submit.prevent="storeOrUpdate" id="eventCreateForm">
      <b-container fluid>

        <b-row class="my-1">
          <b-col sm="3">
            <label for="inputName">Название:</label>
          </b-col>
          <b-col sm="9">
            <b-form-input id="inputName" v-model="event.name" required/>
          </b-col>
        </b-row>

        <b-row class="my-1">
          <b-col sm="3">
            <label for="inputDate">Дата:</label>
          </b-col>
          <b-col sm="9">
            <b-form-input id="inputDate" type="date" v-model="event.date" required/>
          </b-col>
        </b-row>

        <b-row class="my-1">
          <b-col sm="3">
            <label for="inputComputersNumber">Количество компьютеров:</label>
          </b-col>
          <b-col sm="9">
            <b-form-input id="inputComputersNumber" type="number" min="1" v-model="event.computers_number" required/>
          </b-col>
        </b-row>

      </b-container>
    </b-form>

    <div slot="footer">
      <b-button variant="success" class="mr-1" form="eventCreateForm" @click="storeOrUpdate">
        Сохранить
      </b-button>

      <template v-if="$route.params.id">
        <b-button variant="primary" class="mr-1" @click="editHardware">
          Редактор машин
        </b-button>
        <b-button variant="info" class="mr-1" @click="editSoftware">
          Редактор софта
        </b-button>
        <b-button variant="danger" class="mr-1" @click="calculateTime">
          Рассчитать время
        </b-button>
      </template>
    </div>

  </b-card>
</template>

<script>
  import eventApi from "api/tickets/eventApi";

  export default {
    name: "Event",
    components: {},
    data() {
      return {
        event: {
          name: '',
          date: null,
          computers_number: null,
        },
      }
    },
    created() {
      this.fetchData();
    },
    methods: {
      async fetchData() {
        if (!this.hasId()) return;
        this.event = await eventApi.show(this.$route.params.id);
      },
      storeOrUpdate() {
        if (this.hasId()) {
          this.update();
        } else {
          this.store();
        }
      },
      async store() {
        this.event = await eventApi.store(this.event);
        this.alertSuccess();
        this.$router.replace('/events/edit/' + this.event.id);
      },
      async update() {
        await eventApi.update(this.$route.params.id, this.event);
        this.alertSuccess();
      },
      editHardware() {
        this.$router.push('/events/hardware/' + this.$route.params.id);
      },
      editSoftware() {
        this.$router.push('/events/software/' + this.$route.params.id);
      },
      async calculateTime() {
        let calculateTime = await eventApi.calculate(this.$route.params.id);
        alert('Примерное время подготовки: ' + calculateTime);
      }
    }
  }
</script>