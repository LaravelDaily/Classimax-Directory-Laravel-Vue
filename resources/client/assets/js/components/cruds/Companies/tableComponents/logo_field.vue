<template>
    <div v-html="row.logo_link"></div>
</template>


<script>
  export default {
    name: 'LogoField',
    props: ['row', 'xprops'],
  }
</script>
