<template>
  <div>
    <div class="input-group mb-3 mt-3" :style="{width:'30%'}">
      <b-form-input placeholder="Название" v-model="item.name"/>
      <div class="input-group-append">
        <b-button variant="success" @click="store">Добавить</b-button>
      </div>
    </div>

    <b-table class="mt-4"
             hover :items="items"
             :fields="fields">

      <template slot="name" slot-scope="data">
        <template v-if="data.item.is_edit">
          <b-form-input v-model="data.item.name"/>
        </template>
        <template v-else>
          {{ data.item.name }}
        </template>
      </template>

      <template slot="rgb" slot-scope="data">
        <template v-if="data.item.is_edit">
          <!--<b-form-input v-model="data.item.rgb"/>-->
          <chrome-color v-model="data.item.rgb"></chrome-color>
        </template>
        <template v-else>
          <div class="badge badge-primary status-badge"
               :style="{ 'background-color': data.item.rgb}">
            {{ data.item.name }}
          </div>
        </template>
      </template>

      <template slot="actions" slot-scope="data">
        <template v-if="data.item.is_edit">
          <b-button size="sm" variant="success" @click.stop="update(data.item)" class="mr-1">
            Сохранить
          </b-button>
        </template>
        <template v-else>
          <b-button size="sm" variant="primary" @click.stop="edit(data.item)" class="mr-1">
            Редактировать
          </b-button>
          <b-button size="sm" variant="danger" @click.stop="destroy(data.item.id)">
            Удалить
          </b-button>
        </template>
      </template>

    </b-table>
  </div>
</template>

<script>
  export default {
    name: "TicketStatuses",
    data() {
      return {
        entity: 'ticketStatuses',
        item: {},
        items: [],
        fields: [
          {
            key: 'id',
            label: '№',
          },
          {
            key: 'name',
            label: 'Название',
          },
          {
            key: 'rgb',
            label: 'Цвет',
          },
          {
            key: 'actions',
            label: 'Действия'
          }
        ],
      }
    },
    mounted() {
      this.fetchData();
    },
    methods: {
      fetchData() {
        axios.get(this.entity)
          .then(response => this.items = response.data.map(item => {
            item.is_edit = false;
            return item;
          }));
      },
      edit(item) {
        item.is_edit = true;
      },
      update(item) {
        axios.put(this.entity + '/' + item.id, {name: item.name, rgb: item.rgb.hex})
          .then(() => {
            item.rgb = item.rgb.hex;
            item.is_edit = false
          });
      },
      destroy(id) {
        axios.delete(this.entity + '/' + id)
          .then(() => this.deleteById(this.items, id));
      },
      store() {
        axios.post(this.entity, this.item)
          .then(response => {
            response.data.is_edit = false;
            this.items.unshift(response.data);
          });
      }
    },
  }
</script>

<style lang="scss" scoped>

</style>