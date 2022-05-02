<template>
  <div class="wp-loading-bar relative block w-full bg-white overflow-hidden h-[4px]">
    <div class="wp-loading-bar__bar !absolute block bg-primary-500 h-[4px]" />
  </div>
</template>

<style scoped>
.wp-loading-bar {
  height: 4px;
}

.wp-loading-bar__bar {
  left: -50%;
  width: 50%;
  height: 4px;
  animation: wpLoadingBarAnimation 1500ms linear infinite;
}

@keyframes wpLoadingBarAnimation {
  from {
    left: -50%;
    width: 50%;
  }
  50% {
    width: 30%;
  }
  70% {
    width: 70%;
  }
  80% {
    left: 50%;
  }
  95% {
    left: 120%;
  }
  to {
    left: 100%;
  }
}
</style>
