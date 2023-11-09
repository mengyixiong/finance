<template>
  <div class="app-container">

    <el-row style="margin-bottom: 10px">
      <span style="font-size: 28px">员工列表</span>
    </el-row>
    <el-row style="margin-bottom: 10px">
      <el-col :span="4">
        <el-dropdown>
          <el-button type="primary" class="op-btn">
            <i class="iconfont icon-ziyuanxhdpi"></i> 创建 或 过滤员工 <i class="iconfont icon-xiala"></i>
          </el-button>
          <el-dropdown-menu slot="dropdown">
            <el-dropdown-item @click.native="add">
              <i class="iconfont icon-plus">新建一个公司成员</i>
            </el-dropdown-item>

            <el-dropdown-item divided @click.native="queries.is_freeze='Y';fetchData()">
              <i class="iconfont icon-xuanzhong-">已冻结</i>
            </el-dropdown-item>
            <el-dropdown-item @click.native="queries.is_freeze='N';fetchData()">
              <i class="iconfont icon-xuanzhong-">未冻结</i>
            </el-dropdown-item>
            <el-dropdown-item @click.native="queries.is_freeze='';fetchData()">
              <i class="iconfont icon-xuanzhong-">显示所有</i>
            </el-dropdown-item>

            <!-- 导出 -->
            <el-dropdown-item divided><i class="iconfont icon-xiazai"> 导出EXCEL</i></el-dropdown-item>
          </el-dropdown-menu>
        </el-dropdown>
      </el-col>
      <el-col :span="10" :offset="10">
        <el-input placeholder="Search for 员工" @keyup.enter.native="queries.page = 1;fetchData()"
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
            <el-button type="primary" class="op-btn" size="mini">
              <i class="iconfont icon-bianji"></i> 编辑
            </el-button>
            <el-button type="success" class="op-btn" size="mini">
              <i class="iconfont icon-xuanzhong-"></i>密码
            </el-button>
          </template>
        </el-table-column>
        <el-table-column label="头像">
          <template slot-scope="scope">
            <el-avatar size="medium" :src="scope.row.avatar"></el-avatar>
          </template>
        </el-table-column>
        <el-table-column label="真实姓名" align="left">
          <template slot-scope="scope">
            <span>{{ scope.row.nickname }}</span>
          </template>
        </el-table-column>
        <el-table-column label="用户名" align="left">
          <template slot-scope="scope">
            <span>{{ scope.row.username }}</span>
          </template>
        </el-table-column>

        <el-table-column label="冻结" align="left">
          <template slot-scope="scope">
            <el-button :type="scope.row.is_freeze === 'Y'?'danger':'success'" class="op-btn" size="mini">
              {{ scope.row.is_freeze === 'Y' ? '是' : '否' }}
            </el-button>
          </template>
        </el-table-column>

        <el-table-column label="邮箱" align="left">
          <template slot-scope="scope">
            <span>{{ scope.row.email }}</span>
          </template>
        </el-table-column>

        <el-table-column class-name="status-col" label="最后一次登录时间" align="left">
          <template slot-scope="scope">
            <span>{{ scope.row.last_login_at }}</span>
          </template>
        </el-table-column>

        <el-table-column class-name="status-col" label="最后一次登录IP" align="left">
          <template slot-scope="scope">
            <span>{{ scope.row.last_login_ip }}</span>
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

    <create :dialogFormVisible.sync="dialogFormVisible" @added="fetchData"></create>
  </div>
</template>

<script>
import {getList, getPageConfig} from '@/api/system/user'
import Create from "@/views/system/user/create.vue";

export default {
  components: {Create},
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
      dialogFormVisible: false,
      // 类型
      options: {
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
    // await this.pageConfig(); // 等待 pageConfig 完成
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
     * 添加
     */
    add() {
      this.dialogFormVisible = true;
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

.op-btn {
  border-radius: unset;
  font-size: 14px;
  padding: 5px 10px;
  color: white;
  border: none;
}

.op-btn + .op-btn {
  margin-left: 0;
}
</style>
