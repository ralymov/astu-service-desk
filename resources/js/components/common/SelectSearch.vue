<template>
  <div class="selectSearch">

    <div class="dropdown">
      <b-form-input
          :id="id"
          type="text"
          :value="selectedItem.name"
          :placeholder="placeholder"
          @blur.native="onBlurFirst"
          @focus.native="onFocusFirst"
          list="resultList"
          @keydown.down.native="onArrowDown"
          @keydown.up.native="onArrowUp"
          @keydown.enter.native.prevent="onEnter"
          @keydown.esc.native="onEsc"
          :required="required"
          autocomplete="off"
          class="searchSelect"
      />
    </div>


    <div class="searchResult" :class="{hidden:!showSearch}">
      <b-form-input ref="searchInput"
                    class="searchInput"
                    v-model="searchString"
                    @blur.native="onBlurSecond"
                    @focus.native="onFocusSecond"
                    @keydown.down.native="onArrowDown"
                    @keydown.up.native="onArrowUp"
                    @keydown.enter.native.prevent="onEnter"
                    @keydown.esc.native="onEsc">
      </b-form-input>
      <div class="searchResultWrapper">
        <div class="searchResultItem pointer"
             v-for="item,i in filteredItems"
             :class="{ 'active': i === arrowCounter }"
             :key="i"
             @click="selectItem(item)"
             @mousedown="onMouseDown"
             @mouseup="onMouseUp"
             @mouseover="onMouseover(i)">
          {{item.name}}
        </div>
      </div>
    </div>

  </div>
</template>

<script>
  export default {
    name: "SelectSearch",
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
      value: {
        type: [Number, String],
        default: null,
      }
    },
    data() {
      return {
        searchString: '',
        searchItems: [],
        arrowCounter: -1,
        blurFirstInput: true,
        blurSecondInput: true,
        mouseClicked: false,
      }
    },
    computed: {
      filteredItems() {
        if (!this.searchString) return this.searchItems;
        let searchField = this.searchField;
        return this.searchItems.filter(item => {
          return item[searchField].toLowerCase().includes(this.searchString.toLowerCase());
        });
      },
      showSearch() {
        return !this.blurFirstInput || !this.blurSecondInput;
      },
      selectedItem() {
        return this.searchItems.find(item => item.id === this.value) || {};
      }
    },
    mounted() {
      this.fetchData();
    },
    methods: {
      fetchData() {
        axios.get(this.searchTable)
          .then(response => this.searchItems = response.data);
      },
      selectItem(item) {
        this.arrowCounter = -1;
        this.blurFirstInput = true;
        this.blurSecondInput = true;
        this.$emit('selectItem', item.id);
        this.$emit('input', item.id);
        this.$emit('item', item);
      },

      onBlurFirst() {
        if (this.mouseClicked) return;
        setTimeout(() => this.blurFirstInput = true, 100);
      },
      onFocusFirst() {
        this.blurFirstInput = false;
        this.$nextTick(() => this.$refs.searchInput.focus());
      },
      onBlurSecond() {
        if (this.mouseClicked) return;
        setTimeout(() => this.blurSecondInput = true, 100);
      },
      onFocusSecond() {
        this.blurSecondInput = false;
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
        this.selectItem(this.filteredItems[this.arrowCounter]);
        setTimeout(() => this.blurFirstInput = true, 100);
        setTimeout(() => this.blurSecondInput = true, 100);
        this.arrowCounter = -1;
      },
      onEsc() {
        setTimeout(() => this.blurFirstInput = true, 100);
        setTimeout(() => this.blurSecondInput = true, 100);
      },
      onMouseover(i) {
        this.arrowCounter = i;
      },
      onMouseDown() {
        this.mouseClicked = true;
      },
      onMouseUp() {
        this.mouseClicked = false;
      }
    }
  }
</script>

<style lang="scss">
  .selectSearch {
    position: relative;

    .searchResult {
      display: block;
      font-size: 0.8rem;
      line-height: 1.5;
      color: #495057;
      background-color: #fff;
      background-clip: padding-box;
      border: 1px solid #ced4da;
      border-radius: 0.25rem;
      z-index: 500;
      position: absolute;
      width: 100%;

      &.hidden {
        display: none;
      }
    }

    .searchResultWrapper {
      overflow-y: scroll;
      max-height: 250px;
    }

    .searchResultItem {
      height: calc(2.25rem + 2px);
      padding: 0.375rem 0.75rem;

      &.active {
        background: #93d1e8;
      }
    }

    .form-control {
      cursor: pointer;
    }

    .searchInput {
      cursor: auto;
      width: 95%;
      margin: 10px auto;
      height: 30px;
    }

    .searchSelect {
      text-shadow: 0 0 0 gray;
      caret-color: transparent;

      &:focus {
        outline: none;
      }
    }

    .dropdown {
      position: relative;
    }

    .dropdown::before {
      position: absolute;
      content: " \2193";
      top: 7px;
      right: 2px;
      height: 20px;
      width: 20px;
    }
  }
</style>

