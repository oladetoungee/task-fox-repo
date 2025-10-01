import { ref } from 'vue'

export function useModal<T extends string, Data = unknown>(initialModal?: T, data?: Data) {
  const modal = ref<{
    name: T;
    data?: Data;
  } | null>(initialModal ? { name: initialModal, data } : null)

  const openModal = (name: T, data?: Data) => {
    modal.value = { name, data }
  }

  const closeModal = () => {
    modal.value = null
  }

  const modalProps = (name: T, key = 'data') => ({
    open: modal.value?.name === name,
    onOpenChange: (open: boolean) => {
      if (!open) {
        closeModal()
      }
    },
    [key]: modal.value?.data,
  })

  return {
    modal,
    openModal,
    closeModal,
    modalProps
  }
}

