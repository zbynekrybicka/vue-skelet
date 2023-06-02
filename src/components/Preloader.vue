<template>
    <div class="preloader-container">
      <svg class="preloader" viewBox="0 0 50 50">
        <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="4"></circle>
      </svg>
    </div>
  </template>
  
  <script>
  export default {
    name: "Preloader",
  };
  </script>
  
  <style scoped>
  .preloader-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
  }
  
  .preloader {
    animation: rotate 2s linear infinite;
    width: 50px;
    height: 50px;
  }
  
  .path {
    stroke: #50C878;
    stroke-linecap: round;
    animation: dash 1.5s ease-in-out infinite;
  }
  
  @keyframes rotate {
    100% {
      transform: rotate(360deg);
    }
  }
  
  @keyframes dash {
    0% {
      stroke-dasharray: 1, 150;
      stroke-dashoffset: 0;
    }
    50% {
      stroke-dasharray: 90, 150;
      stroke-dashoffset: -35;
    }
    100% {
      stroke-dasharray: 90, 150;
      stroke-dashoffset: -124;
    }
  }
  </style>
  