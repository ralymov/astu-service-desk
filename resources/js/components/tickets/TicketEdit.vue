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
            <b-btn variant="secondary">Редактировать</b-btn>
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
                  <div class="badge badge-primary status-badge"
                       :style="{ 'background-color': _.get(ticket, 'status.rgb') }">
                    {{ _.get(ticket, 'status.name', 'Нет данных') }}
                  </div>
                </td>
                <td class="font-weight-bold">Приоритет</td>
                <td>{{_.get(ticket,'priority.name', 'Нет данных')}}</td>
              </tr>
              </tbody>
            </table>

            <table class="table table-bordered mt-5">
              <tbody>
              <tr>
                <td colspan="2">
                  <b class="mr-5">Тема:</b>{{ticket.title}}
                </td>
              </tr>
              <tr>
                <td class="font-weight-bold">Суть заявки</td>
                <td class="font-weight-bold">Комментарий</td>
              </tr>
              <tr>
                <td>{{ticket.description}}</td>
                <td>{{ticket.comment}}</td>
              </tr>
              </tbody>
            </table>

            <b-button-group class="mt-5 btn-group-justified actions-wrapper">
              <b-button variant="primary">
                <v-icon name="share"/>
                Переадресация
              </b-button>
              <b-button variant="danger">
                <v-icon name="lock"/>
                Заблокировать
              </b-button>
              <b-button variant="success">
                <v-icon name="check"/>
                Выполнено
              </b-button>
            </b-button-group>

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
  export default {
    name: "TicketEdit",
    data() {
      return {
        ticket: {
          applicant: {},
          comments: [],
        },
        comment: '',
      }
    },
    mounted() {
      this.fetchData();
    },
    created: function () {
      document.title = 'Заявка №' + this.$route.params.id;
    },
    methods: {
      fetchData() {
        axios.get(`tickets/${this.$route.params.id}/edit/`)
          .then(response => this.ticket = response.data)
      },
      addComment() {
        axios.post('ticketComments', {text: this.comment, ticket_id: this.ticket.id})
          .then(response => {
            this.ticket.comments.push(response.data);
            this.comment = '';
            this.alertSuccess();
          });
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
  }
</style>