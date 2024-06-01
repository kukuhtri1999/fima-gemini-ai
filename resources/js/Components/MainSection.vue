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
      <div class="flex justify-center py-5">
        <div class="font-bold text-5xl text-purple-600">💵 fima</div>
      </div>
      <div class="w-full text-center flex justify-center mb-8">
        <h1
          class="text-h3 !leading-[66px] !font-semibold text-poppins text-gray-800 max-w-3xl text-center w-full"
        >
          Save your Money and Life with our
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
      <div class="flex justify-center">
        <p
          class="text-gray-500 font-medium max-w-3xl text-center text-xl leading-8"
        >
          AI-Powered Financial Planning: Fima's intelligent algorithms analyze
          your finances and create a personalized roadmap for success.
        </p>
      </div>
      <div class="flex justify-center mt-20">
        <VBtn variant="flat" color="black" size="x-large">Get Started</VBtn>
      </div>
      <div class="flex justify-center mt-10">
        <p class="text-gray-800 max-w-3xl text-center text-[14px] leading-8">
          Powered by Google Gemini AI - Created by Kukuh Tri
        </p>
      </div>
    </div>
  </div>
</template>
