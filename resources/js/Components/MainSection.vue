<script setup></script>

<template>
  <div
    class="w-full bg-white h-screen p-10 bg-blend-multiply bg-center"
    style="
      background-image: url('/storage/images/grad.png'),
        url('/storage/images/a-blur.png');
    "
  >
    <div
      style="background-image: url('/storage/images/dot.png')"
      class="w-full h-full bg-repeat content-center"
    >
      <div class="flex justify-center py-5 animate1">
        <div class="font-bold text-5xl text-purple-600">💵 fima</div>
      </div>
      <div class="w-full text-center flex justify-center mb-8">
        <h1
          class="text-2xl sm:text-4xl sm:!leading-[66px] !font-bold text-poppins text-gray-800 max-w-3xl text-center w-full animate2"
        >
          Save your Money and Life with our <br />
          <span
            style="
              background: linear-gradient(to right, #c65bcf, #10439f);
              -webkit-background-clip: text;
              -webkit-text-fill-color: transparent;
            "
            >AI Financial Manager</span
          >
        </h1>
      </div>
      <div class="flex justify-center animate3">
        <p
          class="text-gray-500 font-medium max-w-3xl text-center text-l sm:text-xl leading-8"
        >
          AI-Powered Financial Planning: Fima's intelligent algorithms analyze
          your finances and create a personalized roadmap for success.
        </p>
      </div>
      <div class="flex justify-center mt-20 animate3">
        <VBtn
          variant="flat"
          color="black"
          size="x-large"
          @click="$emit('scrollToForm')"
          >Get Started</VBtn
        >
      </div>
      <div class="flex justify-center mt-10 animate3">
        <p class="text-gray-800 max-w-3xl text-center text-[14px] leading-8">
          Powered by Google Gemini AI - Created by Kukuh Tri
        </p>
      </div>
    </div>
  </div>
</template>
<style>
.animate1 {
  animation-duration: 2s;
  animation-name: animate-fade;
  animation-delay: 0s;
  animation-fill-mode: backwards;
}

.animate2 {
  animation-duration: 2s;
  animation-name: animate-fade;
  animation-delay: 0.5s;
  animation-fill-mode: backwards;
}

.animate3 {
  animation-duration: 2s;
  animation-name: animate-fade;
  animation-delay: 1.5s;
  animation-fill-mode: backwards;
}

@keyframes animate-fade {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}
</style>
