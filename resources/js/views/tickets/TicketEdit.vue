<template>
  <div class="ticket-edit">
    <b-row>

      <b-col cols="8">
        <b-card header-tag="header"
                footer-tag="footer"
                class="employee-info-card"
                header-bg-variant="primary">

          <div class="d-flex justify-content-between" slot="header">
            <h5 class="text-white font-weight-bold">Заявка №{{ticket.id}}</h5>
            <b-btn variant="success" v-if="editing" @click="save">Сохранить</b-btn>
            <b-btn variant="secondary" v-else @click="edit">Редактировать</b-btn>
          </div>

          <div class="card-text">

            <table class="table table-bordered">
              <tbody>
              <tr>
                <td class="font-weight-bold">Автор</td>
                <td>{{_.get(ticket, 'author.name', 'Нет данных')}}</td>
                <td class="font-weight-bold">Была создана</td>
                <td>{{ticket.created_at}}</td>
              </tr>
              <tr>
                <td class="font-weight-bold">Исполнитель</td>
                <td>{{_.get(ticket,'contractor.name', 'Нет данных')}}</td>
                <td class="font-weight-bold">Редактировалось</td>
                <td>{{ticket.updated_at}}</td>
              </tr>
              <tr>
                <td class="font-weight-bold">Заявитель</td>
                <td>{{_.get(ticket,'applicant.name', ticket.applicant_name)}}</td>
                <td class="font-weight-bold">Последнее обновление</td>
                <td>{{ticket.updated_at}}</td>
              </tr>
              <tr>
                <td class="font-weight-bold">Статус</td>
                <td>
                  <form-select v-model="ticket.status_id" :options="statuses"
                               :firstElement="{value:null,text:'Статус'}" v-if="editing">
                  </form-select>
                  <div class="badge badge-primary status-badge" v-else
                       :style="{ 'background-color': _.get(ticket, 'status.rgb') }">
                    {{ _.get(ticket, 'status.name', 'Нет данных') }}
                  </div>
                </td>
                <td class="font-weight-bold">Приоритет</td>
                <td>
                  <form-select v-model="ticket.priority_id" :options="priorities"
                               :firstElement="{value:null,text:'Приоритет'}" v-if="editing">
                  </form-select>
                  <template v-else>
                    {{_.get(ticket,'priority.name', 'Нет данных')}}
                  </template>
                </td>
              </tr>
              </tbody>
            </table>

            <table class="table table-bordered mt-5">
              <tbody>
              <tr>
                <td colspan="2">
                  <b class="mr-5">Тема:</b>
                  <b-form-input class="inline-form" v-if="editing" v-model="ticket.title" inline/>
                  <template v-else>
                    {{ticket.title}}
                  </template>
                </td>
              </tr>
              <tr>
                <td class="font-weight-bold">Суть заявки</td>
                <td class="font-weight-bold">Комментарий</td>
              </tr>
              <tr>
                <td>
                  <b-form-input class="inline-form" v-if="editing" v-model="ticket.description" inline/>
                  <template v-else>
                    {{ticket.description}}
                  </template>
                </td>
                <td>
                  <b-form-input class="inline-form" v-if="editing" v-model="ticket.comment" inline/>
                  <template v-else>
                    {{ticket.comment}}
                  </template>
                </td>
              </tr>
              </tbody>
            </table>

            <b-button-group class="mt-5 btn-group-justified actions-wrapper">
              <b-button variant="primary" @click="showForwardCollapse=!showForwardCollapse">
                <v-icon name="share"/>
                Переадресация
              </b-button>
              <b-button variant="danger">
                <v-icon name="lock"/>
                Заблокировать
              </b-button>
              <b-button variant="success" @click="confirmCompleteModal=true">
                <v-icon name="check"/>
                Выполнено
              </b-button>
              <confirmation-modal v-model="confirmCompleteModal" @ok="complete"/>
            </b-button-group>

            <b-collapse id="forward" class="mt-2" v-model="showForwardCollapse">
              <b-card>
                <b-form>
                  <b-row class="align-items-center">
                    <b-col cols="12" class="mb-2">
                      Переадресация на:
                    </b-col>
                    <b-col cols="6">
                      <select-search v-model="ticket.department_id"
                                     searchTable="user-departments"
                                     searchField="name">
                      </select-search>
                    </b-col>
                    <b-col cols="6">
                      <select-search v-model="ticket.contractor_id"
                                     searchTable="users"
                                     searchField="name">
                      </select-search>
                    </b-col>
                    <b-col cols="3" class="mt-3">
                      <b-button variant="primary" v-if="ticket.department_id" @click="forward">
                        Подтвердить
                      </b-button>
                    </b-col>
                  </b-row>
                </b-form>
              </b-card>
            </b-collapse>

          </div>
        </b-card>

        <b-tabs class="mt-5">

          <b-tab active>
            <template slot="title">
              <v-icon name="comments"/>
              Комментарии
            </template>
            <b-card header-tag="header"
                    footer-tag="footer"
                    class="employee-info-card"
                    header-bg-variant="success">

              <div class="card-text">
                <div class="timeline-wrapper" v-if="ticket.comments.length">
                  <ul class="timeline">
                    <li v-for="(comment,i) in ticket.comments" :key="i">
                      <p>{{comment.author.name}}</p>
                      <p class="float-right">{{comment.created_at}}</p>
                      <p>{{comment.text}}</p>
                    </li>
                  </ul>
                </div>
                <p v-else>Комментарии отсутствуют.</p>
                <hr>
                <b-form @submit.prevent="addComment">
                  <label for="inputComment" class="font-weight-bold">Ваш комментарий:</label>
                  <b-form-textarea id="inputComment"
                                   v-model="comment"
                                   placeholder="Комментарий"
                                   required
                                   :rows="3"
                                   :max-rows="6">
                  </b-form-textarea>
                  <b-button class="mt-3" type="submit" variant="primary">Добавить</b-button>
                </b-form>
              </div>
            </b-card>
          </b-tab>

          <b-tab>
            <template slot="title">
              <v-icon name="history"/>
              История изменений
            </template>
            <b-card header-tag="header"
                    footer-tag="footer"
                    class="employee-info-card"
                    header-bg-variant="success">

              <div class="card-text">
                <div class="employee-name font-weight-bold">
                  {{_.get(ticket,'applicant.name',ticket.applicant_name)}}
                </div>
                <hr>
                <b-row class="employee-info-item">
                  <b-col cols="4">Должность:</b-col>
                  <b-col cols="8">{{_.get(ticket,'applicant.position.name','Нет данных')}}</b-col>
                </b-row>
                <b-row class="employee-info-item">
                  <b-col cols="4">Отдел:</b-col>
                  <b-col cols="8">{{_.get(ticket,'applicant.department.name','Нет данных')}}</b-col>
                </b-row>
                <b-row class="employee-info-item">
                  <b-col cols="4">Тел:</b-col>
                  <b-col cols="8">{{_.get(ticket,'applicant.phone','Нет данных')}}</b-col>
                </b-row>
                <b-row class="employee-info-item">
                  <b-col cols="4">Кабинет:</b-col>
                  <b-col cols="8">{{_.get(ticket,'applicant.cabinet','Нет данных')}}</b-col>
                </b-row>
              </div>
            </b-card>
          </b-tab>

        </b-tabs>

      </b-col>


      <b-col cols="4">
        <b-card header-tag="header"
                footer-tag="footer"
                class="employee-info-card"
                header-bg-variant="success">

          <div class="d-flex justify-content-between" slot="header">
            <h5 class="text-white font-weight-bold">Информация о сотруднике</h5>
          </div>

          <div class="card-text">
            <div class="employee-name font-weight-bold">
              {{_.get(ticket,'applicant.name',ticket.applicant_name)}}
            </div>
            <hr>
            <b-row class="employee-info-item">
              <b-col cols="4">Должность:</b-col>
              <b-col cols="8">{{_.get(ticket,'applicant.position.name','Нет данных')}}</b-col>
            </b-row>
            <b-row class="employee-info-item">
              <b-col cols="4">Отдел:</b-col>
              <b-col cols="8">{{_.get(ticket,'applicant.department.name','Нет данных')}}</b-col>
            </b-row>
            <b-row class="employee-info-item">
              <b-col cols="4">Тел:</b-col>
              <b-col cols="8">{{_.get(ticket,'applicant.phone','Нет данных')}}</b-col>
            </b-row>
            <b-row class="employee-info-item">
              <b-col cols="4">Кабинет:</b-col>
              <b-col cols="8">{{_.get(ticket,'applicant.cabinet','Нет данных')}}</b-col>
            </b-row>
          </div>
        </b-card>
      </b-col>

    </b-row>
  </div>
</template>

<script>
  import ticketApi from 'api/tickets/ticketApi';
  import ticketStatusesApi from 'api/tickets/ticketStatusesApi';
  import ticketPrioritiesApi from 'api/tickets/ticketPrioritiesApi';
  import ticketCommentsApi from "api/tickets/ticketCommentsApi";

  export default {
    name: "TicketEdit",
    data() {
      return {
        ticket: {
          applicant: {},
          comments: [],
        },
        comment: '',
        editing: false,
        statuses: [],
        priorities: [],
        forwardData: {},
        showForwardCollapse: false,
        confirmCompleteModal: false,
      }
    },
    mounted() {
      this.fetchData();
    },
    created() {
      document.title = 'Заявка №' + this.$route.params.id;
    },
    methods: {
      async fetchData() {
        this.ticket = await ticketApi.edit(this.$route.params.id);
        this.statuses = await ticketStatusesApi.get();
        this.priorities = await ticketPrioritiesApi.get();
      },
      async save() {
        this.ticket = await ticketApi.update(this.$route.params.id, {
          title: this.ticket.title,
          description: this.ticket.description,
          comment: this.ticket.comment,
          priority_id: this.ticket.priority_id,
          status_id: this.ticket.status_id,
        });
        this.editing = false;
      },
      async forward() {
        this.showForwardCollapse = false;
        this.ticket = await ticketApi.update(this.$route.params.id, {
          department_id: this.ticket.department_id,
          contractor_id: this.ticket.contractor_id,
        });
        this.alertSuccess();
      },
      edit() {
        this.editing = true;
      },
      async complete() {
        let closedStatus = this.statuses.find(item => item.name === 'Завершенная');
        this.ticket = await ticketApi.update(this.$route.params.id, {
          closed_at: new Date(),
          status_id: closedStatus.id,
        });
        this.alertSuccess();
      },
      async addComment() {
        let comment = await ticketCommentsApi.store({text: this.comment, ticket_id: this.ticket.id});
        this.ticket.comments.push(comment);
        this.comment = '';
        this.alertSuccess();
      }
    }
  }
</script>

<style lang="scss">
  .ticket-edit {
    .card-header {
      h5 {
        margin-top: 10px;
      }
    }

    .employee-info-item {
      margin-top: 10px;
    }

    .actions-wrapper button {
      height: 45px;
    }

    .employee-name {
      font-size: 20px;
    }

    .fade {
      transition: opacity 0.5s linear;
    }

    .timeline-wrapper {
      overflow-y: auto;
      max-height: 400px;
    }

    ul.timeline {
      list-style-type: none;
      position: relative;
    }

    ul.timeline:before {
      content: ' ';
      background: #d4d9df;
      display: inline-block;
      position: absolute;
      left: 29px;
      width: 2px;
      height: 100%;
      z-index: 400;
    }

    ul.timeline > li {
      margin: 20px 0;
      padding-left: 20px;
    }

    ul.timeline > li:before {
      content: ' ';
      background: white;
      display: inline-block;
      position: absolute;
      border-radius: 50%;
      border: 3px solid #22c0e8;
      left: 20px;
      width: 20px;
      height: 20px;
      z-index: 400;
    }

    .inline-form {
      display: inline-block;
      width: 300px;
    }
  }
</style>