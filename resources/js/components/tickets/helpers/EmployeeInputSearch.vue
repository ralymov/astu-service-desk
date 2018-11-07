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

    <div class="searchResult" v-if="showSearch">
      <div class="searchResultItem pointer"
           v-for="item,i in searchItems"
           :class="{ 'active': i === arrowCounter }"
           :key="i"
           @click="selectItem(item)"
           @mouseover="onMouseover(i)">
        {{item.name}}
        <span class="infoBadge">
          <img src="/icons/info.svg" alt="Информация" :id="'showItemInfoId'+i">
        </span>
        <employee-info-card :target="'showItemInfoId'+i" v-if="onHoverItem"
                            :employee="onHoverItem"></employee-info-card>
      </div>
    </div>

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
      onBlur() {
        //setTimeout(() => this.showSearch = false, 300);
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
</style>

