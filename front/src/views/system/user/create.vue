<template>
  <el-dialog title="添加员工" width="30%" :visible="dialogFormVisible" @close="handleClose">

    <el-form :model="form" :rules="rules" ref="form">
      <el-form-item label="用户名" :label-width="formLabelWidth" prop="username">
        <el-input v-model="form.username" autocomplete="off"></el-input>
      </el-form-item>

      <el-form-item label="真实姓名" :label-width="formLabelWidth" prop="nickname">
        <el-input v-model="form.nickname" autocomplete="off"></el-input>
      </el-form-item>

      <el-form-item label="邮箱" :label-width="formLabelWidth" prop="email">
        <el-input v-model="form.email" autocomplete="off"></el-input>
      </el-form-item>

      <el-form-item label="头像" :label-width="formLabelWidth">
        <el-upload
          list-type="picture"
          name="avatar"
          class="avatar-uploader"
          action="uploadUrl"
          :on-change="test"
          :show-file-list="false"
          :on-success="handleAvatarSuccess"
          :auto-upload="false"
          :before-upload="beforeAvatarUpload">
          <img v-if="form.avatar" :src="form.avatar" class="avatar" alt="">
          <i v-else class="el-icon-plus avatar-uploader-icon"></i>
        </el-upload>
      </el-form-item>

    </el-form>

    <div slot="footer" class="dialog-footer">
      <el-button @click="resetForm('form')">重置</el-button>
      <el-button type="primary" @click="submitForm('form')">确 定</el-button>
    </div>

  </el-dialog>
</template>

<script>
import {addUser} from '@/api/system/user'

export default {
  name: 'Create',
  props: ['dialogFormVisible'],
  data() {
    return {
      form: {
        username: '',
        nickname: '',
        email: '',
        avatar: '',
      },
      rules: {
        username: [
          {required: true, message: '请输入用户名', trigger: 'blur'},
          {min: 4, max: 16, message: '长度在 4 到 16 个字符', trigger: 'blur'}
        ],
        nickname: [
          {required: true, message: '请输入真实姓名', trigger: 'blur'},
          {min: 2, max: 4, message: '长度在 2 到 4 个字符', trigger: 'blur'}
        ],
      },
      formLabelWidth: '100px'
    }
  },
  methods: {
    test(file, fileList) {
      console.log(file)
      console.log(fileList)
    },
    /**
     * 关闭弹窗
     */
    handleClose() {
      this.$emit('update:dialogFormVisible', false);
    },

    handleAvatarSuccess(res, file) {
      this.form.avatar = URL.createObjectURL(file.raw);
      this.submitForm('form');
    },

    beforeAvatarUpload(file) {
      const isLt2M = file.size / 1024 / 1024 < 2;

      if (!isLt2M) {
        this.$message.error('上传头像图片大小不能超过 2MB!');
      }
      return isLt2M;
    },

    // 上传服务器
    submitUpload() {
      this.$refs.upload.submit();
    },

    /**
     * 添加用户
     * @param formName
     */
    submitForm(formName) {
      this.$refs[formName].validate((valid) => {
        if (!valid) {
          return false;
        }
        addUser(this.form).then(response => {
          this.$message.success(response.message)
          this.$refs[formName].resetFields();
          this.handleClose();
          this.$emit('added'); // 发出一个自定义事件
        })
      });
    },

    /**
     * 重置表单
     * @param formName
     */
    resetForm(formName) {
      this.$refs[formName].resetFields();
    }
  }
}
</script>

<style scoped>

.avatar-uploader {
  width: 100px;
  border: 1px dashed #d9d9d9;
  border-radius: 6px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}

.avatar-uploader:hover {
  border-color: #409EFF;
}

.avatar-uploader-icon {
  font-size: 28px;
  color: #8c939d;
  width: 100px;
  height: 100px;
  line-height: 100px;
  text-align: center;
}

.avatar {
  width: 178px;
  height: 178px;
  display: block;
}
</style>
