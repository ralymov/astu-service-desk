<template>
  <div class="referenceTableList">

    <b-row class="mb-3 mt-2">
      <b-col cols="6">
        <b-form inline @submit.prevent="store">
          <div class="input-group">
            <select-search v-model="item.program_id"
                           searchTable="programs"
                           searchField="name"
                           @item="item.name = $event.name">
            </select-search>
            <div class="input-group-append">
              <b-button variant="success" type="submit">Добавить</b-button>
            </div>
          </div>
        </b-form>
      </b-col>
    </b-row>

    <b-table class="mt-4"
             hover :items="softList"
             :fields="fields">

      <template slot="name" slot-scope="data">
        <template v-if="data.item.is_edit">
          <select-search v-model="data.item.program_id"
                         searchTable="programs"
                         searchField="name"
                         @item="data.item.name = $event.name">
          </select-search>
        </template>
        <template v-else>
          {{ data.item.name }}
        </template>
      </template>

      <template slot="actions" slot-scope="row" class="action-slot">
        <template v-if="row.item.is_edit">
          <b-button size="sm" variant="success" @click.stop="update(row.item)" class="mr-1">
            Сохранить
          </b-button>
        </template>
        <template v-else>
          <b-button size="sm" variant="primary" @click.stop="edit(row.item)" class="mr-1">
            Редактировать
          </b-button>
          <b-button size="sm" variant="danger" @click.stop="destroy(row.index)">
            Удалить
          </b-button>
        </template>
      </template>

    </b-table>

  </div>
</template>

<script>
  import ReferenceTableList from 'common/ReferenceTableList'
  import eventApi from "api/tickets/eventApi";

  export default {
    components: {
      ReferenceTableList
    },
    data() {
      return {
        software: [],
        event: {},
        item: {is_edit: false},
        softList: [],
        fields: [
          {
            key: 'name',
            label: 'Название',
          },
          {
            key: 'actions',
            label: 'Действия'
          }
        ],
      }
    },
    created() {
      this.fetchData();
    },
    methods: {
      async fetchData() {
        if (!this.hasId()) return;
        this.event = await eventApi.show(this.$route.params.id);
        this.software = this.event.software;
        this.processSoftware();
      },
      processSoftware() {
        const vm = this;
        this.softList = this.software;
        this.softList.forEach(function (item) {
          vm.$set(item, 'is_edit', false);
        });
      },
      edit(item) {
        item.is_edit = true;
      },
      store() {
        this.software.push(this.item);
        let soft = this.software.map(function (item) {
          delete item.is_edit;
          return item;
        });
        eventApi.update(this.$route.params.id, {software: soft});
        this.processSoftware();
        this.item = {is_edit: false};
        this.alertSuccess();
      },
      update(item) {
        let soft = this.software.map(function (item) {
          delete item.is_edit;
          return item;
        });
        eventApi.update(this.$route.params.id, {software: soft});
        this.processSoftware();
        item.is_edit = false;
      },
      destroy(rowIndex) {
        this.softList.splice(rowIndex, 1);
        this.software.splice(rowIndex, 1);
        let soft = this.software.map(function (item) {
          delete item.is_edit;
          return item;
        });
        eventApi.update(this.$route.params.id, {software: soft});
        this.processSoftware();
      },
    }
  }
</script>

