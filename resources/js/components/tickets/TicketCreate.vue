<template>
  <b-modal id="ticketCreate" ref="ticketCreate" class="ticketCreate" title="Новая заявка"
           body-class="pt-0"
           hide-footer @shown.once="show" no-close-on-esc>

    <div slot="modal-header-close">
      <img class="icon" src="/icons/close.svg" alt="Close">
    </div>

    <b-form @submit.prevent="createTicket">
      <b-row class="mt-3 mb-5">

        <b-col cols="6">
          <label for="inputTitle">Тема:</label>
          <b-form-input id="inputTitle"
                        v-model="ticket.title"
                        type="text"
                        placeholder="Тема заявки"
                        required></b-form-input>
        </b-col>
        <b-col cols="6">

          <label for="inputApplicant">От кого:</label>
          <employee-input-search id="inputApplicant"
                                 placeholder="ФИО пользователя"
                                 v-model="ticket.applicant_name"
                                 @selectItem="ticket.applicant_id=$event"
                                 @item="selectedEmployee=$event"
                                 searchTable="employees"
                                 searchField="name">
          </employee-input-search>
        </b-col>

        <b-col cols="4" class="mt-3">
          <label for="selectType">Тип заявки:</label>
          <form-select id="selectType" v-model="ticket.type_id" :options="ticketTypes" required></form-select>
        </b-col>
        <b-col cols="4" class="mt-3">
          <label for="selectPriority">Приоритет заявки:</label>
          <form-select id="selectPriority" v-model="ticket.priority_id" :options="ticketPriorities"></form-select>
        </b-col>
        <b-col cols="4" class="mt-3">
          <label for="inputContractor">Кому:</label>
          <input-search id="inputContractor"
                        placeholder="ФИО сотрудника"
                        v-model="ticket.employee_name"
                        @selectItem="ticket.contractor_id=$event"
                        searchTable="users"
                        searchField="name">
          </input-search>
        </b-col>

        <b-col cols="12" class="mt-3">
          <label for="inputDescription">Описание заявки:</label>
          <b-form-textarea id="inputDescription"
                           v-model="ticket.description"
                           placeholder="Суть заявки"
                           :rows="3"
                           :max-rows="6"
                           no-resize
                           required>
          </b-form-textarea>
        </b-col>

        <b-col cols="12" class="mt-3">
          <label for="inputComment">Комментарий:</label>
          <b-form-textarea id="inputComment"
                           v-model="ticket.comment"
                           placeholder="Дополнительная информация, если отличается от профиля пользователя: номер телефона, аудитория, подразделение"
                           :rows="2"
                           :max-rows="4"
                           no-resize>
          </b-form-textarea>
        </b-col>

      </b-row>

      <b-btn type="submit" variant="primary" size="lg">Создать</b-btn>

    </b-form>

  </b-modal>
</template>

<script>
  import EmployeeInputSearch from './helpers/EmployeeInputSearch';

  export default {
    name: "TicketCreate",
    components: {
      EmployeeInputSearch
    },
    data() {
      return {
        ticket: {},
        ticketTypes: [],
        ticketPriorities: [],
        ticketStatuses: [],

        selectedEmployee: {},
      }
    },
    methods: {
      show() {
        this.loadDictionaries();
      },
      loadDictionaries() {
        axios.get('ticketTypes')
          .then(response => this.ticketTypes = response.data);
        axios.get('ticketPriorities')
          .then(response => this.ticketPriorities = response.data);
        axios.get('ticketStatuses')
          .then(response => this.ticketStatuses = response.data);
      },
      createTicket() {
        axios.post('tickets', this.postParams())
          .then(response => {
            this.alertSuccess();
            this.ticket = {};
            this.$emit('ticketCreated', response.data);
            this.$refs.ticketCreate.hide();
          })
      },
      postParams() {
        let ticket = this.ticket;
        delete ticket.employee_name;
        return ticket;
      },
    },
  }
</script>

<style lang="scss">
  .ticketCreate {
    .modal-dialog {
      max-width: 1050px;
    }

    .input-group {
      width: 350px;
    }

    label {
      font-weight: bold;
    }
  }
</style>
