<template>
  <reference-table-list
      entity="users"
      nameFieldLabel="Имя"
      :additionalFields="additionalFields"
      hideForm
  >

    <template slot="before-table">
      <b-button variant="success" @click="create">Новый пользователь</b-button>
    </template>

    <template slot="department" slot-scope="data">
      <template v-if="data.item.is_edit">
        <form-select v-model="data.item.department_id" :options="departments"
                     :firstElement="{value:null,text:'Отдел'}">
        </form-select>
      </template>
      <template v-else>
        {{_.get(data.item, 'department.name', 'Нет данных')}}
      </template>
    </template>

    <template slot="position" slot-scope="data">
      <template v-if="data.item.is_edit">
        <form-select v-model="data.item.position_id" :options="positions"
                     :firstElement="{value:null,text:'Должность'}">
        </form-select>
      </template>
      <template v-else>
        {{_.get(data.item, 'position.name', 'Нет данных')}}
      </template>
    </template>

  </reference-table-list>
</template>

<script>
  import ReferenceTableList from 'components/common/ReferenceTableList'

  export default {
    name: "UserCreate",
    components: {
      ReferenceTableList
    },
    data() {
      return {
        additionalFields: [
          {
            key: 'department',
            label: 'Отдел'
          },
          {
            key: 'position',
            label: 'Должность'
          },
        ]
      }
    },
    methods: {
      create() {
        this.$router.push('users/create');
      }
    }
  }
</script>
