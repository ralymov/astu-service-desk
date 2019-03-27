<template>
  <reference-table-list
      entity="departments"
      :additionalFields="additionalFields"
      :requestFields="['name','location_id']">

    <template slot="location" slot-scope="data">
      <template v-if="data.item.is_edit">
        <form-select v-model="data.item.location_id" :options="locations"></form-select>
      </template>
      <template v-else>
        {{_.get(data.item, 'location.name', 'Нет данных')}}
      </template>
    </template>

  </reference-table-list>
</template>

<script>
  import ReferenceTableList from 'common/ReferenceTableList'

  export default {
    name: "Departments",
    components: {
      ReferenceTableList
    },
    data() {
      return {
        locations: [],
        additionalFields: [
          {
            key: 'location',
            label: 'Местонахождение'
          },
        ]
      }
    },
    mounted() {
      this.fetchLocations();
    },
    methods: {
      fetchLocations() {
        axios.get('locations')
          .then(response => this.locations = response.data);
      }
    }
  }
</script>
