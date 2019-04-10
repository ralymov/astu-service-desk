<template>
  <reference-table-list
      entity="processors"
      ref="processorsList"
      :additionalFields="additionalFields"
      nameFieldLabel="Название"
      :requestFields="['name', 'processors_number', 'frequency']"
      paginate
  >

    <template slot="form-inputs" slot-scope="data">
      <b-form-input placeholder="Количество процессоров" v-model="data.item.processors_number"
                    type="number" min="0" required/>
      <b-form-input placeholder="Частота, Гц" v-model="data.item.frequency"
                    type="number" min="0" required step="10"/>
    </template>

    <template slot="processors_number" slot-scope="data">
      <template v-if="data.item.is_edit">
        <b-form-input placeholder="Количество процессоров" v-model="data.item.processors_number" min="0" type="number"/>
      </template>
      <template v-else>
        {{_.get(data.item, 'processors_number', 'Нет данных')}}
      </template>
    </template>

    <template slot="frequency" slot-scope="data">
      <template v-if="data.item.is_edit">
        <b-form-input placeholder="Частота, Гц" v-model="data.item.frequency" type="number" min="0" step="10"/>
      </template>
      <template v-else>
        {{_.get(data.item, 'frequency', 'Нет данных')}}
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
            key: 'processors_number',
            label: 'Количество процессоров, шт.'
          },
          {
            key: 'frequency',
            label: 'Частота, Гц'
          },
        ]
      }
    },
  }
</script>

