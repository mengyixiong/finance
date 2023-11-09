<template>
  <el-container>
    <el-container>
      <el-main>
        <el-scrollbar style="height: calc(100vh - 100px);">
          <div v-for="message in messages" :key="message.id">
            <!-- 根据消息类型决定是显示左侧还是右侧 -->
            <div v-if="message.type === 'received'" class="message received">
              <el-avatar :src="message.avatar"></el-avatar>
              <div class="text">{{ message.text }}</div>
            </div>
            <div v-else class="message sent">
              <div class="text">{{ message.text }}</div>
              <el-avatar :src="message.avatar"></el-avatar>
            </div>
          </div>
        </el-scrollbar>
      </el-main>
      <el-footer>
        <el-row>
          <el-col :span="20">
            <el-input v-model="newMessage" placeholder="输入消息..."></el-input>
          </el-col>
          <el-col :span="4">
            <el-button type="primary" @click="sendMessage">发送</el-button>
          </el-col>
        </el-row>
      </el-footer>
    </el-container>
  </el-container>
</template>

<script>

export default {
  data() {
    return {
      newMessage: '',
      messages: [
        {
          avatar:'',
          text:'测试',
          type:'avatar'
        }
      ]
    }
  },
  methods: {
    sendMessage() {
      if (!this.newMessage) return;
      // 发送消息的逻辑
      this.messages.push({
        id: Date.now(),
        text: this.newMessage,
        type: 'sent',
        // avatar: 'path/to/sender/avatar.jpg'
      });
      this.newMessage = '';
      // 滚动到底部逻辑
      // ...
    }
  }
}
</script>
<style>
.message {
  display: flex;
  align-items: center;
}

.received {
  justify-content: flex-start;
}

.sent {
  justify-content: flex-end;
}

.text {
  padding: 10px;
  border-radius: 4px;
  margin: 5px;
  background-color: #f9f9f9;
}
</style>
