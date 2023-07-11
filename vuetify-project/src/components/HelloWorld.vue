<template>
  <v-sheet class="d-flex flex-wrap ">
    <v-sheet class="flex-1-0 ma-2 pa-2">
      I'm an element in an inline flexbox container!
      <form >
     
         <v-text-field
         
         :counter="10"
         label="Name"
         ></v-text-field>
     
       </form>
    </v-sheet>

    <v-sheet class="ma-2 pa-2">
      I'm a single element in an inline flexbox container!
    </v-sheet>

    <v-sheet class="flex-1-1-100 ma-2 pa-2">
      I'm a single element in an inline flexbox container!
    </v-sheet>
  </v-sheet>

</template>