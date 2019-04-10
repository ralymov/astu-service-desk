<template>
  <reference-table-list
      entity="ram"
      ref="ramList"
      :additionalFields="additionalFields"
      nameFieldLabel="Название"
      :requestFields="['name', 'generation', 'frequency', 'memory_size']"
      paginate
  >

    <template slot="form-inputs" slot-scope="data">
      <b-form-input placeholder="Поколение" v-model="data.item.generation"
                    type="number" min="0" required/>
      <b-form-input placeholder="Частота, Мгц" v-model="data.item.frequency"
                    type="number" min="0" required step="10"/>
      <b-form-input placeholder="Объем памяти, Гб" v-model="data.item.memory_size"
                    type="number" min="0" required/>
    </template>

    <template slot="generation" slot-scope="data">
      <template v-if="data.item.is_edit">
        <b-form-input placeholder="Поколение" v-model="data.item.generation" min="0" type="number"/>
      </template>
      <template v-else>
        {{_.get(data.item, 'generation', 'Нет данных')}}
      </template>
    </template>

    <template slot="frequency" slot-scope="data">
      <template v-if="data.item.is_edit">
        <b-form-input placeholder="Частота, МГц" v-model="data.item.frequency" type="number" min="0" step="10"/>
      </template>
      <template v-else>
        {{_.get(data.item, 'frequency', 'Нет данных')}}
      </template>
    </template>

    <template slot="memory_size" slot-scope="data">
      <template v-if="data.item.is_edit">
        <b-form-input placeholder="Объем памяти, Гб" v-model="data.item.memory_size" min="0" type="number"/>
      </template>
      <template v-else>
        {{_.get(data.item, 'memory_size', 'Нет данных')}}
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
            key: 'generation',
            label: 'Поколение, №'
          },
          {
            key: 'frequency',
            label: 'Частота, Мгц'
          },
          {
            key: 'memory_size',
            label: 'Объем памяти, Гб'
          },
        ]
      }
    },
  }
</script>

