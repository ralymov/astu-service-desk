<template>
  <b-popover :target="target"
             triggers="hover focus">
    <b-card header-tag="header"
            footer-tag="footer"
            class="employee-info-card"
            header-bg-variant="success">

      <h5 slot="header" class="mb-0">Информация о сотруднике</h5>

      <div class="card-text">
        <div class="employee-name">{{employee.name}}</div>
        <hr>
        <b-row class="employee-info-item">
          <b-col cols="4">Должность:</b-col>
          <b-col cols="8">{{_.get(employee,'position.name','Нет данных')}}</b-col>
        </b-row>
        <b-row class="employee-info-item">
          <b-col cols="4">Отдел:</b-col>
          <b-col cols="8">{{_.get(employee,'department.name','Нет данных')}}</b-col>
        </b-row>
        <b-row class="employee-info-item">
          <b-col cols="4">Тел:</b-col>
          <b-col cols="8">{{employee.phone || 'Нет данных'}}</b-col>
        </b-row>
        <b-row class="employee-info-item">
          <b-col cols="4">Кабинет:</b-col>
          <b-col cols="8">{{employee.cabinet || 'Нет данных'}}</b-col>
        </b-row>
      </div>
    </b-card>
  </b-popover>
</template>

<script>

  export default {
    name: "EmployeeInfoCard",
    props: {
      employee: {
        type: Object,
        default: () => {
        },
      },
      target: {
        type: String,
        default: 'employeeInfoPopover',
      }
    },
    data() {
      return {}
    },
    mounted() {

    },
    methods: {}
  }
</script>

<style lang="scss" scoped>
  .employee-info-card {
    width: 400px;
    .employee-name {
      font-size: 18px;
      font-weight: bold;
    }
    .employee-info-item {
      font-size: 16px;
    }
    .popover {
      max-width: 100%;
    }
  }
</style>
