<template>
  <footer class="py-3 footer position-fixed" >
    <div class="container-fluid">
      <div class="row align-items-center justify-content-lg-between">
        <div class="mb-4 col-lg-6 mb-lg-0">
          <div
            class="text-sm text-center copyright text-muted"
            :class="this.$store.state.isRTL ? 'text-lg-end' : 'text-lg-start'"
          >
            ©
            {{ new Date().getFullYear() }}
            <a
              href="https://www.creative-tim.com"
              class="font-weight-bold"
              target="_blank"
              >PTM AMS INDONESIA</a
            >
            Human Resource Management.
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script>
export default {
  name: "app-footer",
};
</script>
