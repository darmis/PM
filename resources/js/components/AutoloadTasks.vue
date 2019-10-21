<template>

    <div class="autoload-tasks-container">
        <div v-for="task in list" :key="task.id" class="">
            <a href="'/task/' + task.id" >
                <div class="">
                    {{ task.status }}
                </div>
            </a>
        </div>
        <infinite-loading spinner="waveDots" @infinite="infiniteHandler">
            <span slot="no-more"></span>
        </infinite-loading>
    </div>

</template>

<style>
    .autoload-tasks-container {
        overflow-y: scroll;
    }
</style>

<script>

    import InfiniteLoading from 'vue-infinite-loading';

    import axios from 'axios';

const api = '//hn.algolia.com/api/v1/search_by_date?tags=story';

export default {
  data() {
    return {
      page: 1,
      list: [],
    };
  },
  methods: {
    infiniteHandler($state) {
      axios.get(api, {
        params: {
          page: this.page,
        },
      }).then(({ data }) => {
        if (data.hits.length) {
          this.page += 1;
          this.list.push(...data.hits);
          $state.loaded();
        } else {
          $state.complete();
        }
      });
    },
  },
};

</script>
