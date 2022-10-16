<template>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" 
    :name="name" 
    :id="id" 
    :checked="checked"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)" />
    <label :for="id" class="custom-control-label">
      <slot />
    </label>
  </div>
</template>

<script>
export default {
  emits: ['update:modelValue'],
  name: "argon-checkbox",
  props: {
    name: String,
    id: String,
    checked: String,
    modelValue: '',
  },
  methods: {
    updateValue(event) {
            this.$emit('update:modelvalue', event.target.value);
        },
  },
};
</script>
