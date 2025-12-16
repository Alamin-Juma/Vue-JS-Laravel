<template>
  <div class="item mt-8 flex relative lg:mt-0 lg:pl-20 lg:pb-4 lg:pt-1.5 lg:before:content-[''] lg:before:absolute lg:before:left-0 lg:before:bottom-[calc(50%+25px)] lg:before:h-[calc(50%-25px)] lg:before:border-l lg:before:border-gray-300 lg:after:content-[''] lg:after:absolute lg:after:left-0 lg:after:top-[calc(50%+25px)] lg:after:h-[calc(50%-25px)] lg:after:border-l lg:after:border-gray-300 first:lg:before:hidden last:lg:after:hidden">
    <i class="flex items-center justify-center w-8 h-8 text-gray-700 lg:absolute lg:top-[calc(50%-25px)] lg:-left-[26px] lg:w-[50px] lg:h-[50px] lg:bg-white lg:border lg:border-gray-300 lg:rounded-lg lg:z-10">
      <slot name="icon"></slot>
    </i>
    <div class="details flex-1 ml-4 lg:ml-0">
      <h3 class="text-xl font-medium mb-1.5 text-gray-900">
        <slot name="heading"></slot>
      </h3>
      <div class="text-gray-600">
        <slot></slot>
      </div>
    </div>
  </div>
</template>
