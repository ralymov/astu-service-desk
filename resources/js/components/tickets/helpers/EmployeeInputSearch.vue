<template>
  <div class="inputSearch">

    <b-form-input
        @input.native="input"
        :id="id"
        type="text"
        v-model="value"
        :placeholder="placeholder"
        @blur.native="onBlur"
        @focus.native="onFocus"
        list="resultList"
        @keydown.down.native="onArrowDown"
        @keydown.up.native="onArrowUp"
        @keydown.enter.native.prevent="onEnter"
        @keydown.esc.native="onEsc"
        :required="required"
        autocomplete="off"
    />

    <div class="searchResult" v-if="showSearch" @mousedown="onMousedown" @mouseup="onMouseup">
      <div class="searchResultItem pointer"
           v-for="item,i in searchItems"
           :class="{ 'active': i === arrowCounter }"
           :key="i"
           @click="selectItem(item)"
           @mouseover="onMouseover(i)">
        {{item.name}}
        <span class="infoBadge">
          <img src="/icons/info.svg" alt="Информация" :id="'showItemInfoId'+i" @click.stop="openEmployeeInfo(item)">
        </span>
        <employee-info-card :target="'showItemInfoId'+i" v-if="onHoverItem"
                            :employee="onHoverItem"></employee-info-card>
      </div>
    </div>

    <b-modal ref="editEmployeeInfoModal"
             class="editEmployeeInfoModal"
             title="Информация о сотруднике"
             body-class="pt-0"
             hide-footer
             @show.once="fetchReferences">
      <b-row class="mt-3">
        <b-col sm="3">
          <label for="position-input">Должность</label>
        </b-col>
        <b-col sm="9">
          <form-select v-model="editingEmployee.position_id" :options="positions" id="position-input"
                       :firstElement="{value:null,text:'Должность'}">
          </form-select>
        </b-col>
      </b-row>
      <b-row class="mt-2">
        <b-col sm="3">
          <label for="department-input">Отдел</label>
        </b-col>
        <b-col sm="9">
          <form-select v-model="editingEmployee.department_id" :options="departments" id="department-input"
                       :firstElement="{value:null,text:'Отдел'}">
          </form-select>
        </b-col>
      </b-row>
      <b-row class="mt-2">
        <b-col sm="3">
          <label for="phone-input">Телефон</label>
        </b-col>
        <b-col sm="9">
          <b-form-input id="phone-input" v-model="editingEmployee.phone"/>
        </b-col>
      </b-row>
      <b-row class="mt-2">
        <b-col sm="3">
          <label for="cabinet-input">Кабинет</label>
        </b-col>
        <b-col sm="9">
          <b-form-input id="cabinet-input" v-model="editingEmployee.cabinet"/>
        </b-col>
      </b-row>
      <b-row class="mt-3">
        <b-col sm="3">
          <b-button variant="success" @click="updateEmployee">Сохранить</b-button>
        </b-col>
      </b-row>
    </b-modal>

  </div>
</template>

<script>
  import EmployeeInfoCard from './EmployeeInfoCard';

  export default {
    name: "InputSearch",
    components: {
      EmployeeInfoCard
    },
    props: {
      placeholder: {
        type: String,
        default: '',
      },
      id: {
        type: String,
        default: '',
      },
      searchTable: {
        type: String,
        default: '',
        required: true,
      },
      searchField: {
        type: String,
        default: '',
        required: true,
      },
      additionalSearchConditionals: {
        type: Array,
        default: () => [],
      },
      required: {
        type: Boolean,
        default: false,
      },
    },
    data() {
      return {
        value: null,
        showSearch: false,
        selectedItem: {},
        searchItems: [],
        arrowCounter: -1,
        mousedown: false,

        editingEmployee: {},
        positions: [],
        departments: [],
      }
    },
    computed: {
      onHoverItem() {
        let item = this.searchItems[this.arrowCounter];
        this.$emit('hoverItem', item);
        return item;
      }
    },
    methods: {
      input() {
        this.search();
        this.$emit('input', this.value);
        this.$emit('selectItem', null);
        this.$emit('item', {});
      },
      search() {
        if (!this.value) {
          this.searchItems = [];
          return;
        }
        if (this.value.length < 3) return;
        axios.post('employees/search', {
          field_name: this.searchField,
          search_string: this.value,
          search_conditionals: this.additionalSearchConditionals,
          relations: ['position', 'department'],
        })
          .then(response => {
            this.searchItems = response.data;
            this.showSearch = this.value !== this.selectedItem.name;
          });
      },
      selectItem(item) {
        this.value = item.name;
        this.selectedItem = item;
        this.searchItems = [];
        this.showSearch = false;
        this.$emit('selectItem', item.id);
        this.$emit('item', item);
      },
      openEmployeeInfo(item) {
        this.editingEmployee = item;
        this.$refs.editEmployeeInfoModal.show();
      },
      async updateEmployee() {
        console.log(this.editingEmployee);
        axios.put(`employees/${this.editingEmployee.id}`, this.editingEmployee);
        this.editingEmployee = {};
        this.$refs.editEmployeeInfoModal.hide();
      },
      fetchReferences() {
        axios.get('departments')
          .then(response => this.departments = response.data);
        axios.get('positions')
          .then(response => this.positions = response.data);
      },
      onBlur() {
        if (this.mousedown) return;
        this.showSearch = false;
      },
      onFocus() {
        this.showSearch = true;
      },
      onArrowDown() {
        if (this.arrowCounter < this.searchItems.length) {
          this.arrowCounter = this.arrowCounter + 1;
        }
      },
      onArrowUp() {
        if (this.arrowCounter > 0) {
          this.arrowCounter = this.arrowCounter - 1;
        }
      },
      onEnter() {
        this.selectItem(this.searchItems[this.arrowCounter]);
        this.showSearch = false;
        this.arrowCounter = -1;
      },
      onEsc() {
        this.showSearch = false;
      },
      onMouseover(i) {
        this.arrowCounter = i;
      },
      onMousedown() {
        this.mousedown = true;
      },
      onMouseup() {
        this.mousedown = false;
      }
    }
  }
</script>

<style lang="scss">
  .inputSearch {
    .infoBadge img {
      width: 20px;
      position: absolute;
      right: 10px;
      top: 8px;
    }
  }

  .editEmployeeInfoModal {
    .modal-content {
      width: 600px;
      margin: 0 auto;
    }
  }
</style>

