import ChooseTemplateModal from "../components/Modals/ChooseTemplateModal.vue";
import { ModalProgrammatic as Modal } from 'buefy'

export function openTicketModal(hid, uid, parent) {
    Modal.open({
      parent: parent,
      component: ChooseTemplateModal,
      hasModalCard: true,
      trapFocus: true,
      props: { hid, uid },
    });
  }