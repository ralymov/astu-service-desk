<template>
  <div class="referenceTableList">

    <b-row class="mb-3 mt-2" v-if="!hideForm">
      <b-col cols="6">
        <b-form inline @submit.prevent="store">
          <div class="input-group">
            <b-form-input placeholder="Название" v-model="item.name" required/>
            <slot name="form-inputs" :item="item"></slot>
            <div class="input-group-append">
              <b-button variant="success" type="submit">Добавить</b-button>
            </div>
          </div>
        </b-form>
      </b-col>
      <slot name="additional-forms"></slot>

      <b-col cols="12" class="mt-2" v-if="allowSearch">
        <b-input-group prepend="Поиск" class="mt-3 w-50">
          <b-form-input v-model="search" @keydown.enter="fetchDataPaginate(1)"/>
          <b-input-group-append>
            <b-button variant="info" @click="fetchDataPaginate(1)">
              <v-icon name="search"/>
            </b-button>
            <b-button variant="danger" @click="clearSearch">
              <v-icon name="times"/>
            </b-button>
          </b-input-group-append>
        </b-input-group>
      </b-col>
    </b-row>

    <slot name="before-table"></slot>

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

      <template v-for="field in additionalFields" :slot="field.key" slot-scope="data">
        <slot :name="field.key" v-bind="data">{{ data.item[field.key] }}</slot>
      </template>

      <template slot="actions" slot-scope="data" class="action-slot">
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

    <b-pagination
      v-if="paginate"
      v-model="currentPage"
      :total-rows="totalRows"
      :per-page="perPage"
      @input="changePage"
    />

  </div>
</template>

<script>
  export default {
    name: "ReferenceTableList",
    props: {
      entity: {
        type: String,
        default: '',
        required: true,
      },
      hideForm: {
        type: Boolean,
        default: false,
      },
      additionalFields: {
        type: Array,
        default: () => [],
      },
      requestFields: {
        type: Array,
        default: () => ['name']
      },
      nameFieldLabel: {
        type: String,
        default: 'Название',
      },
      editPath: {
        type: String,
        default: null,
      },
      paginate: {
        type: Boolean,
        default: false,
      },
      allowSearch: {
        type: Boolean,
        default: false,
      },
    },
    data() {
      return {
        currentPage: 1,
        totalRows: 1,
        perPage: 1,
        item: {},
        items: [],
        search: '',
        initialFields: [
          {
            key: 'name',
            label: this.nameFieldLabel,
          },
          {
            key: 'actions',
            label: 'Действия'
          }
        ],
      }
    },
    computed: {
      fields() {
        return this.initialFields.slice(0, -1).concat(this.additionalFields)
          .concat(this.initialFields[this.initialFields.length - 1]);
      }
    },
    created() {
      this.paginate ? this.fetchDataPaginate() : this.fetchData();
    },
    methods: {

      fetchData() {
        this.allowSearch ? this.fetchDataWithSearch() : this.fetchDataWithoutSearch();
      },
      fetchDataWithoutSearch() {
        axios.get(this.entity)
          .then(response => this.setIsEditToFalse(response));
      },
      fetchDataWithSearch() {
        axios.post(`${this.entity}/search}`, {
          field_name: 'name',
          search_string: this.search,
        }).then(response => {
          this.setIsEditToFalse(response);
          this.perPage = response.data.per_page;
          this.totalRows = response.data.total;
        });
      },

      fetchDataPaginate(page = 1) {
        this.allowSearch ? this.fetchDataPaginateWithSearch(page) : this.fetchDataPaginateWithoutSearch(page);
      },
      fetchDataPaginateWithSearch(page = 1) {
        axios.post(`${this.entity}/search/?page=${page}`, {
          field_name: 'name',
          search_string: this.search,
          relations: ['position', 'department'],
          paginate: true,
        }).then(response => {
          this.setIsEditToFalse(response);
          this.perPage = response.data.per_page;
          this.totalRows = response.data.total;
        });
      },
      fetchDataPaginateWithoutSearch(page = 1) {
        axios.get(`${this.entity}/?page=${page}`).then(response => {
          this.setIsEditToFalse(response);
          this.perPage = response.data.per_page;
          this.totalRows = response.data.total;
        });
      },

      edit(item) {
        if (this.editPath) this.$router.push(this.editPath + item.id);
        item.is_edit = true;
      },
      store() {
        axios.post(this.entity, this.item)
          .then(response => {
            response.data.is_edit = false;
            this.items.unshift(response.data);
            this.item = {is_edit: false};
          });
      },
      update(item) {
        let data = {};
        this.requestFields.map(value => data[value] = item[value]);
        axios.put(this.entity + '/' + item.id, data)
          .then(response => {
            response.data.is_edit = false;
            this.$set(this.items, this.findById(this.items, response.data.id), response.data);
          });
      },
      destroy(id) {
        axios.delete(this.entity + '/' + id)
          .then(() => this.deleteById(this.items, id));
      },

      changePage(page) {
        this.fetchDataPaginate(page);
      },
      clearSearch() {
        this.search = '';
        this.paginate ? this.fetchDataPaginate() : this.fetchData();
      },
      setIsEditToFalse(response) {
        if (response.data.data) {
          this.items = response.data.data.map(item => {
            item.is_edit = false;
            return item;
          });
        } else {
          this.items = response.data.map(item => {
            item.is_edit = false;
            return item;
          });
        }
      }
    },
  }
</script>
