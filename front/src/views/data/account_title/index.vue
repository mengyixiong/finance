<template>
  <div class="app-container">

    <el-row style="margin-bottom: 10px">
      <span style="font-size: 28px">会计科目</span> —— {{ labelText }}
    </el-row>
    <el-row style="margin-bottom: 10px">
      <el-col :span="4">
        <el-dropdown>
          <el-button type="primary">
            <i class="iconfont icon-ziyuanxhdpi"></i> 过滤 科目余额初始化<i class="iconfont icon-xiala"></i>
          </el-button>
          <el-dropdown-menu slot="dropdown">
            <el-dropdown-item @click.native="queries.type='';fetchData()">
              <i class="iconfont icon-xuanzhong-">显示所有</i>
            </el-dropdown-item>

            <!-- 等级选择 -->
            <el-dropdown-item
              :divided="index===0"
              v-for="(item,index) in options.types" @click.native="queries.type=item.value;fetchData()">
              <i class="iconfont icon-xuanzhong-"> {{ item.label }}</i>
            </el-dropdown-item>

            <!-- 导出 -->
            <el-dropdown-item divided><i class="iconfont icon-xiazai"> 导出EXCEL</i></el-dropdown-item>
          </el-dropdown-menu>
        </el-dropdown>
      </el-col>
      <el-col :span="10" :offset="10">
        <el-input placeholder="Search for 会计科目" @keyup.enter.native="queries.page = 1;fetchData()"
                  v-model="queries.keyword"
                  size="mini">
          <el-button slot="append" class="iconfont icon-sousuo-xianxing"
                     @click="queries.page = 1;fetchData()"></el-button>
        </el-input>
      </el-col>
    </el-row>


    <el-row style="margin-bottom: 10px">
      <el-table
        :height="640"
        v-loading="listLoading"
        :data="page.data"
        element-loading-text="Loading"
        border
        fit
        highlight-current-row
      >
        <el-table-column align="center" label="操作" width="200">
          <template slot-scope="scope">
            <el-button v-show="scope.row.is_freezed === 'N'" type="success" style="background: #5bc0de" size="mini">
              <i class="iconfont icon-buxianshi"></i> 冻结
            </el-button>
            <el-button v-show="scope.row.is_freezed === 'Y'" type="danger"  size="mini">
              <i class="iconfont icon-xianshi"></i> 激活
            </el-button>

            <el-button type="primary" size="mini">
              <i class="iconfont icon-bianji"></i> 编辑
            </el-button>
            <el-button type="success" size="mini">
              <i class="iconfont icon-plus"></i>子科目
            </el-button>
          </template>
        </el-table-column>
        <el-table-column label="科目代码" width="100">
          <template slot-scope="scope">
            {{ scope.row.code }}
          </template>
        </el-table-column>
        <el-table-column label="级次" width="60" align="left">
          <template slot-scope="scope">
            <span>{{ scope.row.level }}</span>
          </template>
        </el-table-column>
        <el-table-column label="科目类型" width="110" align="left">
          <template slot-scope="scope">
            {{ scope.row.typeText }}
          </template>
        </el-table-column>
        <el-table-column class-name="status-col" label="余额方向" width="110" align="left">
          <template slot-scope="scope">
            <el-button :type="scope.row.is_dn === 'Y'?'success':'danger'" size="mini">
              {{ scope.row.is_dn === 'Y' ? '借方' : '贷方' }}
            </el-button>
          </template>
        </el-table-column>
        <el-table-column class-name="status-col" label="速记代码" width="110" align="left">
          <template slot-scope="scope">
            <span>{{ scope.row.abb }}</span>
          </template>
        </el-table-column>
        <el-table-column
          show-overflow-tooltip
          class-name="status-col" label="科目中文名" align="left">
          <template slot-scope="scope">
            <span>{{ scope.row.cn_name }}</span>
          </template>
        </el-table-column>
        <el-table-column
          show-overflow-tooltip
          class-name="status-col" label="科目英文名" align="left">
          <template slot-scope="scope">
            <span>{{ scope.row.en_name }}</span>
          </template>
        </el-table-column>
        <el-table-column class-name="status-col" label="账页格式" width="110" align="left">
          <template slot-scope="scope">
            <span>{{ scope.row.formatText }}</span>
          </template>
        </el-table-column>
        <el-table-column class-name="status-col" label="外币核算" width="110" align="left">
          <template slot-scope="scope">
            <el-checkbox v-model="scope.row.is_foreign" disabled true-label="Y" false-label="N"></el-checkbox>
          </template>
        </el-table-column>
        <el-table-column class-name="status-col" label="核算币种" width="110" align="left">
          <template slot-scope="scope">
            <span>{{ scope.row.currency }}</span>
          </template>
        </el-table-column>
        <el-table-column class-name="status-col" label="末级科目" width="110" align="left">
          <template slot-scope="scope">
            <el-checkbox v-model="scope.row.is_last" disabled true-label="Y" false-label="N"></el-checkbox>
          </template>
        </el-table-column>
        <el-table-column class-name="status-col" label="现金流科目" width="110" align="left">
          <template slot-scope="scope">
            <el-checkbox v-model="scope.row.is_cash" disabled true-label="Y" false-label="N"></el-checkbox>
          </template>
        </el-table-column>
      </el-table>
    </el-row>
    <el-row style="margin-bottom: 10px;text-align: right">
      <el-pagination
        prev-text="上一页"
        next-text="下一页"
        @size-change="handleSizeChange"
        @current-change="handleCurrentChange"
        :current-page="page.current_page"
        :page-sizes="[10,15, 20, 300, 400]"
        :page-size="queries.limit"
        layout="total, sizes, prev, pager, next, jumper"
        :total="page.total">
      </el-pagination>
    </el-row>

  </div>
</template>

<script>
import {getList, getPageConfig} from '@/api/data/account_title'

export default {
  computed: {
    // 计算属性定义
    labelText() {
      if (this.queries.type) {
        const item = this.options.types.find((item) => item.value === this.queries.type);
        return item ? item.label : '';
      }
      return '所有科目';
    }
  },
  data() {
    return {
      // 类型
      options: {
        types: [],
        formats: [],
        levels: []
      },
      queries: {
        page: 1,
        limit: 20,
        type: ''
      },
      page: {},
      listLoading: true
    }
  },
  async created() {
    await this.pageConfig(); // 等待 pageConfig 完成
    await this.fetchData();  // 然后调用 fetchData
  },
  methods: {
    handleSizeChange(val) {
      this.queries.page = val;
      this.fetchData()
    },
    handleCurrentChange(val) {
      this.queries.page = val;
      this.fetchData()
    },

    /**
     * 获取页面配置信息
     */
    async pageConfig() {
      return getPageConfig().then(response => {
        this.queries.type = response.data.type;
        this.options = response.data;
      })
    },

    /**
     * 获取数据
     */
    async fetchData() {
      this.listLoading = true
      getList(this.queries).then(response => {
        this.page = response.data;
        this.listLoading = false
      })
    }
  }
}
</script>
<style>
.el-table td {
  padding: 4px 0;
}

.el-button {
  border-radius: unset;
  font-size: 12px;
  padding: 5px 5px;
  color: white;
  border: none;
}

.el-button + .el-button {
  margin-left: 0;
}
</style>
