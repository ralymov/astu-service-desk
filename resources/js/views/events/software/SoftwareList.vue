<template>
  <reference-table-list
      entity="programs"
      ref="softwareList"
      :additionalFields="additionalFields"
      nameFieldLabel="Название"
      :requestFields="['name','processor_weight','ram_weight']"
      editPath="/software/edit/"
      paginate
      hideForm
  >

    <template slot="before-table">
      <b-button variant="success" @click="create">Новое ПО</b-button>
    </template>

    <template slot="processor_weight" slot-scope="data">
      <template v-if="data.item.is_edit">
        <b-form-input v-model="data.item.processor_weight" type="number"/>
      </template>
      <template v-else>
        {{ data.item.processor_weight }}
      </template>
    </template>

    <template slot="ram_weight" slot-scope="data">
      <template v-if="data.item.is_edit">
        <b-form-input v-model="data.item.ram_weight" type="number"/>
      </template>
      <template v-else>
        {{ data.item.ram_weight }}
      </template>
    </template>

  </reference-table-list>
</template>

<script>
  import ReferenceTableList from 'common/ReferenceTableList'

  export default {
    components: {
      ReferenceTableList
    },
    data() {
      return {
        additionalFields: [
          {
            key: 'processor_weight',
            label: 'Весовой коэффициент для процессора'
          },
          {
            key: 'ram_weight',
            label: 'Весовой коэффициент для ОЗУ'
          },
        ]
      }
    },
    methods: {
      create() {
        this.$router.push('/software/create');
      }
    },
  }
</script>

