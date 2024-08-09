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
      <div class="flex justify-center mt-6 space-x-6 animate3">
        <a
          href="https://www.instagram.com/kukuhtriw"
          target="_blank"
          rel="noopener noreferrer"
          class="text-gray-600 hover:text-gray-800"
        >
          <span class="sr-only">Instagram</span>
          <svg
            class="w-6 h-6"
            fill="currentColor"
            viewBox="0 0 24 24"
            aria-hidden="true"
          >
            <path
              fill-rule="evenodd"
              d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
              clip-rule="evenodd"
            />
          </svg>
        </a>
        <a
          href="https://github.com/kukuhtri1999/fima-gemini-ai"
          target="_blank"
          rel="noopener noreferrer"
          class="text-gray-600 hover:text-gray-800"
        >
          <span class="sr-only">GitHub</span>
          <svg
            class="w-6 h-6"
            fill="currentColor"
            viewBox="0 0 24 24"
            aria-hidden="true"
          >
            <path
              fill-rule="evenodd"
              d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
              clip-rule="evenodd"
            />
          </svg>
        </a>
        <a
          href="https://www.linkedin.com/in/kukuhtri99/"
          target="_blank"
          rel="noopener noreferrer"
          class="text-gray-600 hover:text-gray-800"
        >
          <span class="sr-only">LinkedIn</span>
          <svg
            class="w-6 h-6"
            fill="currentColor"
            viewBox="0 0 24 24"
            aria-hidden="true"
          >
            <path
              fill-rule="evenodd"
              d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"
              clip-rule="evenodd"
            />
          </svg>
        </a>
        <a
          href="https://wa.me/6282232161707"
          target="_blank"
          rel="noopener noreferrer"
          class="text-gray-600 hover:text-gray-800"
        >
          <span class="sr-only">WhatsApp</span>
          <svg
            class="w-6 h-6"
            fill="currentColor"
            viewBox="0 0 24 24"
            aria-hidden="true"
          >
            <path
              fill-rule="evenodd"
              d="M20.448 3.538C18.176 1.266 15.152 0 11.996 0 5.438 0 0.0960002 5.342 0.0960002 11.9C0.0960002 14 0.692 16.05 1.824 17.85L0 24L6.3 22.212C8.024 23.246 9.988 23.79 11.996 23.79C18.554 23.79 23.896 18.448 23.896 11.89C23.896 8.734 22.63 5.71 20.358 3.438L20.448 3.538ZM11.996 21.79C10.218 21.79 8.484 21.268 6.974 20.312L6.614 20.088L2.864 21.168L3.956 17.508L3.71 17.136C2.662 15.566 2.096 13.766 2.096 11.9C2.096 6.444 6.54 2 11.996 2C14.642 2 17.154 3.066 19.048 4.96C20.942 6.854 22.008 9.366 22.008 12.012C21.896 17.468 17.452 21.79 11.996 21.79ZM17.42 14.366C17.132 14.232 15.686 13.52 15.442 13.43C15.198 13.34 15.02 13.296 14.842 13.584C14.664 13.872 14.106 14.54 13.95 14.718C13.794 14.896 13.638 14.918 13.35 14.784C13.062 14.65 12.112 14.322 10.996 13.32C10.128 12.54 9.53 11.59 9.374 11.302C9.218 11.014 9.352 10.87 9.486 10.738C9.62 10.606 9.754 10.43 9.888 10.274C10.022 10.118 10.066 10.006 10.156 9.828C10.246 9.65 10.202 9.494 10.134 9.36C10.066 9.226 9.486 7.78 9.264 7.204C9.042 6.628 8.82 6.716 8.664 6.716C8.508 6.716 8.33 6.694 8.152 6.694C7.974 6.694 7.686 6.762 7.442 7.05C7.198 7.338 6.442 8.05 6.442 9.496C6.442 10.942 7.508 12.344 7.642 12.522C7.776 12.7 9.508 15.368 12.154 16.63C12.822 16.92 13.35 17.1 13.75 17.232C14.418 17.452 15.02 17.43 15.508 17.364C16.04 17.298 17.22 16.674 17.442 16.01C17.664 15.346 17.664 14.792 17.596 14.696C17.528 14.6 17.35 14.544 17.062 14.41L17.42 14.366Z"
              clip-rule="evenodd"
            />
          </svg>
        </a>
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
