<?php

/**
 * IOPAY Checkout v1.0
 *
 * Class ControllerExtensionPaymentIOCheckout
 */
class ControllerExtensionPaymentIOPAYCheckoutTransparenteCard extends Controller {
	private $error = array();

	public function index() {

        $this->load->model('customer/custom_field'); //aqui puxa o model do catalog/account/custom_field
        $custom_fields = $this->model_customer_custom_field->getCustomFields();

        $this->load->language('extension/payment/iopay_checkout_transparente_card');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('payment_iopay_checkout_transparente_card', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

        $data['custom_fields'] = $custom_fields; // custom fields for mapping

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/payment/iopay_checkout_transparente_card', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/payment/iopay_checkout_transparente_card', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true);


        if (isset($this->request->post['payment_iopay_checkout_transparente_card_mapping_user_primarydocument'])) {
            $data['payment_iopay_checkout_transparente_card_mapping_user_primarydocument'] = $this->request->post['payment_iopay_checkout_transparente_card_mapping_user_primarydocument'];
        } else {
            $data['payment_iopay_checkout_transparente_card_mapping_user_primarydocument'] = $this->config->get('payment_iopay_checkout_transparente_card_mapping_user_primarydocument');
        }

        if (isset($this->request->post['payment_iopay_checkout_transparente_card_mapping_shipping_primarydocument'])) {
            $data['payment_iopay_checkout_transparente_card_mapping_shipping_primarydocument'] = $this->request->post['payment_iopay_checkout_transparente_card_mapping_shipping_primarydocument'];
        } else {
            $data['payment_iopay_checkout_transparente_card_mapping_shipping_primarydocument'] = $this->config->get('payment_iopay_checkout_transparente_card_mapping_shipping_primarydocument');
        }

        if (isset($this->request->post['payment_iopay_checkout_transparente_card_mapping_shipping_addressnumber'])) {
            $data['payment_iopay_checkout_transparente_card_mapping_shipping_addressnumber'] = $this->request->post['payment_iopay_checkout_transparente_card_mapping_shipping_addressnumber'];
        } else {
            $data['payment_iopay_checkout_transparente_card_mapping_shipping_addressnumber'] = $this->config->get('payment_iopay_checkout_transparente_card_mapping_shipping_addressnumber');
        }

		if (isset($this->request->post['payment_iopay_checkout_transparente_card_email'])) {
			$data['payment_iopay_checkout_transparente_card_email'] = $this->request->post['payment_iopay_checkout_transparente_card_email'];
		} else {
			$data['payment_iopay_checkout_transparente_card_email'] = $this->config->get('payment_iopay_checkout_transparente_card_email');
		}

        if (isset($this->request->post['payment_iopay_checkout_transparente_card_ioid'])) {
            $data['payment_iopay_checkout_transparente_card_ioid'] = $this->request->post['payment_iopay_checkout_transparente_card_ioid'];
        } else {
            $data['payment_iopay_checkout_transparente_card_ioid'] = $this->config->get('payment_iopay_checkout_transparente_card_ioid');
        }

        if (isset($this->request->post['payment_iopay_checkout_transparente_card_io_api_secret'])) {
            $data['payment_iopay_checkout_transparente_card_io_api_secret'] = $this->request->post['payment_iopay_checkout_transparente_card_io_api_secret'];
        } else {
            $data['payment_iopay_checkout_transparente_card_io_api_secret'] = $this->config->get('payment_iopay_checkout_transparente_card_io_api_secret');
        }

        if (isset($this->request->post['payment_iopay_checkout_transparente_card_antifraud_type'])) {
            $data['payment_iopay_checkout_transparente_card_antifraud_type'] = $this->request->post['payment_iopay_checkout_transparente_card_antifraud_type'];
        } else {
            $data['payment_iopay_checkout_transparente_card_antifraud_type'] = $this->config->get('payment_iopay_checkout_transparente_card_antifraud_type');
        }

        if (isset($this->request->post['payment_iopay_checkout_transparente_card_antifraud_id'])) {
            $data['payment_iopay_checkout_transparente_card_antifraud_id'] = $this->request->post['payment_iopay_checkout_transparente_card_antifraud_id'];
        } else {
            $data['payment_iopay_checkout_transparente_card_antifraud_id'] = $this->config->get('payment_iopay_checkout_transparente_card_antifraud_id');
        }

		if (isset($this->request->post['payment_iopay_checkout_transparente_card_test'])) {
			$data['payment_iopay_checkout_transparente_card_test'] = $this->request->post['payment_iopay_checkout_transparente_card_test'];
		} else {
			$data['payment_iopay_checkout_transparente_card_test'] = $this->config->get('payment_iopay_checkout_transparente_card_test');
		}

		if (isset($this->request->post['payment_iopay_checkout_transparente_card_transaction'])) {
			$data['payment_iopay_checkout_transparente_card_transaction'] = $this->request->post['payment_iopay_checkout_transparente_card_transaction'];
		} else {
			$data['payment_iopay_checkout_transparente_card_transaction'] = $this->config->get('payment_iopay_checkout_transparente_card_transaction');
		}

		if (isset($this->request->post['payment_iopay_checkout_transparente_card_debug'])) {
			$data['payment_iopay_checkout_transparente_card_debug'] = $this->request->post['payment_iopay_checkout_transparente_card_debug'];
		} else {
			$data['payment_iopay_checkout_transparente_card_debug'] = $this->config->get('payment_iopay_checkout_transparente_card_debug');
		}

		if (isset($this->request->post['payment_iopay_checkout_transparente_card_total'])) {
			$data['payment_iopay_checkout_transparente_card_total'] = $this->request->post['payment_iopay_checkout_transparente_card_total'];
		} else {
			$data['payment_iopay_checkout_transparente_card_total'] = $this->config->get('payment_iopay_checkout_transparente_card_total');
		}

		if (isset($this->request->post['payment_iopay_checkout_transparente_card_canceled_reversal_status_id'])) {
			$data['payment_iopay_checkout_transparente_card_canceled_reversal_status_id'] = $this->request->post['payment_iopay_checkout_transparente_card_canceled_reversal_status_id'];
		} else {
			$data['payment_iopay_checkout_transparente_card_canceled_reversal_status_id'] = $this->config->get('payment_iopay_checkout_transparente_card_canceled_reversal_status_id');
		}

		if (isset($this->request->post['payment_iopay_checkout_transparente_card_completed_status_id'])) {
			$data['payment_iopay_checkout_transparente_card_completed_status_id'] = $this->request->post['payment_iopay_checkout_transparente_card_completed_status_id'];
		} else {
			$data['payment_iopay_checkout_transparente_card_completed_status_id'] = $this->config->get('payment_iopay_checkout_transparente_card_completed_status_id');
		}

		if (isset($this->request->post['payment_iopay_checkout_transparente_card_denied_status_id'])) {
			$data['payment_iopay_checkout_transparente_card_denied_status_id'] = $this->request->post['payment_iopay_checkout_transparente_card_denied_status_id'];
		} else {
			$data['payment_iopay_checkout_transparente_card_denied_status_id'] = $this->config->get('payment_iopay_checkout_transparente_card_denied_status_id');
		}

		if (isset($this->request->post['payment_iopay_checkout_transparente_card_expired_status_id'])) {
			$data['payment_iopay_checkout_transparente_card_expired_status_id'] = $this->request->post['payment_iopay_checkout_transparente_card_expired_status_id'];
		} else {
			$data['payment_iopay_checkout_transparente_card_expired_status_id'] = $this->config->get('payment_iopay_checkout_transparente_card_expired_status_id');
		}

		if (isset($this->request->post['payment_iopay_checkout_transparente_card_failed_status_id'])) {
			$data['payment_iopay_checkout_transparente_card_failed_status_id'] = $this->request->post['payment_iopay_checkout_transparente_card_failed_status_id'];
		} else {
			$data['payment_iopay_checkout_transparente_card_failed_status_id'] = $this->config->get('payment_iopay_checkout_transparente_card_failed_status_id');
		}

		if (isset($this->request->post['payment_iopay_checkout_transparente_card_pending_status_id'])) {
			$data['payment_iopay_checkout_transparente_card_pending_status_id'] = $this->request->post['payment_iopay_checkout_transparente_card_pending_status_id'];
		} else {
			$data['payment_iopay_checkout_transparente_card_pending_status_id'] = $this->config->get('payment_iopay_checkout_transparente_card_pending_status_id');
		}

		if (isset($this->request->post['payment_iopay_checkout_transparente_card_processed_status_id'])) {
			$data['payment_iopay_checkout_transparente_card_processed_status_id'] = $this->request->post['payment_iopay_checkout_transparente_card_processed_status_id'];
		} else {
			$data['payment_iopay_checkout_transparente_card_processed_status_id'] = $this->config->get('payment_iopay_checkout_transparente_card_processed_status_id');
		}

		if (isset($this->request->post['payment_iopay_checkout_transparente_card_refunded_status_id'])) {
			$data['payment_iopay_checkout_transparente_card_refunded_status_id'] = $this->request->post['payment_iopay_checkout_transparente_card_refunded_status_id'];
		} else {
			$data['payment_iopay_checkout_transparente_card_refunded_status_id'] = $this->config->get('payment_iopay_checkout_transparente_card_refunded_status_id');
		}

		if (isset($this->request->post['payment_iopay_checkout_transparente_card_reversed_status_id'])) {
			$data['payment_iopay_checkout_transparente_card_reversed_status_id'] = $this->request->post['payment_iopay_checkout_transparente_card_reversed_status_id'];
		} else {
			$data['payment_iopay_checkout_transparente_card_reversed_status_id'] = $this->config->get('payment_iopay_checkout_transparente_card_reversed_status_id');
		}

		if (isset($this->request->post['payment_iopay_checkout_transparente_card_voided_status_id'])) {
			$data['payment_iopay_checkout_transparente_card_voided_status_id'] = $this->request->post['payment_iopay_checkout_transparente_card_voided_status_id'];
		} else {
			$data['payment_iopay_checkout_transparente_card_voided_status_id'] = $this->config->get('payment_iopay_checkout_transparente_card_voided_status_id');
		}

        if (isset($this->request->post['payment_iopay_checkout_transparente_card_installment_fee_1x'])) {
            $data['payment_iopay_checkout_transparente_card_installment_fee_1x'] = $this->request->post['payment_iopay_checkout_transparente_card_installment_fee_1x'];
        } else {
            $data['payment_iopay_checkout_transparente_card_installment_fee_1x'] = $this->config->get('payment_iopay_checkout_transparente_card_installment_fee_1x');
        }

        if (isset($this->request->post['payment_iopay_checkout_transparente_card_installment_fee_2x'])) {
            $data['payment_iopay_checkout_transparente_card_installment_fee_2x'] = $this->request->post['payment_iopay_checkout_transparente_card_installment_fee_2x'];
        } else {
            $data['payment_iopay_checkout_transparente_card_installment_fee_2x'] = $this->config->get('payment_iopay_checkout_transparente_card_installment_fee_2x');
        }

        if (isset($this->request->post['payment_iopay_checkout_transparente_card_installment_fee_3x'])) {
            $data['payment_iopay_checkout_transparente_card_installment_fee_3x'] = $this->request->post['payment_iopay_checkout_transparente_card_installment_fee_3x'];
        } else {
            $data['payment_iopay_checkout_transparente_card_installment_fee_3x'] = $this->config->get('payment_iopay_checkout_transparente_card_installment_fee_3x');
        }

        if (isset($this->request->post['payment_iopay_checkout_transparente_card_installment_fee_4x'])) {
            $data['payment_iopay_checkout_transparente_card_installment_fee_4x'] = $this->request->post['payment_iopay_checkout_transparente_card_installment_fee_4x'];
        } else {
            $data['payment_iopay_checkout_transparente_card_installment_fee_4x'] = $this->config->get('payment_iopay_checkout_transparente_card_installment_fee_4x');
        }

        if (isset($this->request->post['payment_iopay_checkout_transparente_card_installment_fee_5x'])) {
            $data['payment_iopay_checkout_transparente_card_installment_fee_5x'] = $this->request->post['payment_iopay_checkout_transparente_card_installment_fee_5x'];
        } else {
            $data['payment_iopay_checkout_transparente_card_installment_fee_5x'] = $this->config->get('payment_iopay_checkout_transparente_card_installment_fee_5x');
        }

        if (isset($this->request->post['payment_iopay_checkout_transparente_card_installment_fee_6x'])) {
            $data['payment_iopay_checkout_transparente_card_installment_fee_6x'] = $this->request->post['payment_iopay_checkout_transparente_card_installment_fee_6x'];
        } else {
            $data['payment_iopay_checkout_transparente_card_installment_fee_6x'] = $this->config->get('payment_iopay_checkout_transparente_card_installment_fee_6x');
        }

        if (isset($this->request->post['payment_iopay_checkout_transparente_card_installment_fee_7x'])) {
            $data['payment_iopay_checkout_transparente_card_installment_fee_7x'] = $this->request->post['payment_iopay_checkout_transparente_card_installment_fee_7x'];
        } else {
            $data['payment_iopay_checkout_transparente_card_installment_fee_7x'] = $this->config->get('payment_iopay_checkout_transparente_card_installment_fee_7x');
        }

        if (isset($this->request->post['payment_iopay_checkout_transparente_card_installment_fee_8x'])) {
            $data['payment_iopay_checkout_transparente_card_installment_fee_8x'] = $this->request->post['payment_iopay_checkout_transparente_card_installment_fee_8x'];
        } else {
            $data['payment_iopay_checkout_transparente_card_installment_fee_8x'] = $this->config->get('payment_iopay_checkout_transparente_card_installment_fee_8x');
        }

        if (isset($this->request->post['payment_iopay_checkout_transparente_card_installment_fee_9x'])) {
            $data['payment_iopay_checkout_transparente_card_installment_fee_9x'] = $this->request->post['payment_iopay_checkout_transparente_card_installment_fee_9x'];
        } else {
            $data['payment_iopay_checkout_transparente_card_installment_fee_9x'] = $this->config->get('payment_iopay_checkout_transparente_card_installment_fee_9x');
        }

        if (isset($this->request->post['payment_iopay_checkout_transparente_card_installment_fee_10x'])) {
            $data['payment_iopay_checkout_transparente_card_installment_fee_10x'] = $this->request->post['payment_iopay_checkout_transparente_card_installment_fee_10x'];
        } else {
            $data['payment_iopay_checkout_transparente_card_installment_fee_10x'] = $this->config->get('payment_iopay_checkout_transparente_card_installment_fee_10x');
        }

        if (isset($this->request->post['payment_iopay_checkout_transparente_card_installment_fee_11x'])) {
            $data['payment_iopay_checkout_transparente_card_installment_fee_11x'] = $this->request->post['payment_iopay_checkout_transparente_card_installment_fee_11x'];
        } else {
            $data['payment_iopay_checkout_transparente_card_installment_fee_11x'] = $this->config->get('payment_iopay_checkout_transparente_card_installment_fee_11x');
        }

        if (isset($this->request->post['payment_iopay_checkout_transparente_card_installment_fee_12x'])) {
            $data['payment_iopay_checkout_transparente_card_installment_fee_12x'] = $this->request->post['payment_iopay_checkout_transparente_card_installment_fee_12x'];
        } else {
            $data['payment_iopay_checkout_transparente_card_installment_fee_12x'] = $this->config->get('payment_iopay_checkout_transparente_card_installment_fee_12x');
        }

        if (isset($this->request->post['payment_iopay_checkout_transparente_card_installment_max'])) {
            $data['payment_iopay_checkout_transparente_card_installment_max'] = $this->request->post['payment_iopay_checkout_transparente_card_installment_max'];
        } else {
            $data['payment_iopay_checkout_transparente_card_installment_max'] = $this->config->get('payment_iopay_checkout_transparente_card_installment_max');
        }

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['payment_iopay_checkout_transparente_card_geo_zone_id'])) {
			$data['payment_iopay_checkout_transparente_card_geo_zone_id'] = $this->request->post['payment_iopay_checkout_transparente_card_geo_zone_id'];
		} else {
			$data['payment_iopay_checkout_transparente_card_geo_zone_id'] = $this->config->get('payment_iopay_checkout_transparente_card_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['payment_iopay_checkout_transparente_card_status'])) {
			$data['payment_iopay_checkout_transparente_card_status'] = $this->request->post['payment_iopay_checkout_transparente_card_status'];
		} else {
			$data['payment_iopay_checkout_transparente_card_status'] = $this->config->get('payment_iopay_checkout_transparente_card_status');
		}

		if (isset($this->request->post['payment_iopay_checkout_sort_order'])) {
			$data['payment_iopay_checkout_transparente_card_sort_order'] = $this->request->post['payment_iopay_checkout_transparente_card_sort_order'];
		} else {
			$data['payment_iopay_checkout_transparente_card_sort_order'] = $this->config->get('payment_iopay_checkout_transparente_card_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/payment/iopay_checkout_transparente_card', $data));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/payment/iopay_checkout_transparente_card')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['payment_iopay_checkout_transparente_card_email']) {
			$this->error['email'] = $this->language->get('error_email');
		}

		return !$this->error;
	}
}