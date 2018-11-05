<template>
  <reference-table-list entity="employees" ref="employeesList" :additionalFields="additionalFields">

    <template slot="form-inputs" slot-scope="data">
      <form-select v-model="data.item.department_id" :options="departments"
                   :firstElement="{value:null,text:'Отдел'}">
      </form-select>
      <form-select v-model="data.item.position_id" :options="positions"
                   :firstElement="{value:null,text:'Должность'}">
      </form-select>
    </template>

    <template slot="additional-forms">
      <b-col>
        <b-form inline @submit.prevent="importCsv" class="ml-2">
          <div class="input-group">
            <b-form-file v-model="employeeListFile" accept=".csv" placeholder="CSV с сотрудниками" required/>
            <div class="input-group-append">
              <b-button variant="success" type="submit">Импортировать</b-button>
            </div>
          </div>
        </b-form>
      </b-col>
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
    name: "Employees",
    components: {
      ReferenceTableList
    },
    data() {
      return {
        employeeListFile: null,
        departments: [],
        positions: [],
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
    mounted() {
      this.fetchReferences();
    },
    methods: {
      fetchReferences() {
        axios.get('departments')
          .then(response => this.departments = response.data);
        axios.get('positions')
          .then(response => this.positions = response.data);
      },
      importCsv() {
        let formData = new FormData();
        formData.append("csv", this.employeeListFile);
        axios.post('employees/import', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }).then(() => {
          this.$refs.employeesList.fetchData();
          this.alertSuccess();
        });
      }
    }
  }
</script>

