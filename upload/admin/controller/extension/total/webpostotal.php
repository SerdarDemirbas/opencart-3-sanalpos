<?php
class ControllerExtensionTotalWebposTotal extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/total/webpostotal');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('total_webpostotal', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/total/webpostotal', 'user_token=' . $this->session->data['user_token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_single_ratio'] = $this->language->get('entry_single_ratio');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_total'),
			'href' => $this->url->link('extension/total', 'user_token=' . $this->session->data['user_token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/total/webpostotal', 'user_token=' . $this->session->data['user_token'], 'SSL')
		);

		$data['action'] = $this->url->link('extension/total/webpostotal', 'user_token=' . $this->session->data['user_token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/total', 'user_token=' . $this->session->data['user_token'], 'SSL');

		if (isset($this->request->post['webpostotal_status'])) {
			$data['total_webpostotal_status'] = $this->request->post['total_webpostotal_status'];
		} else {
			$data['total_webpostotal_status'] = $this->config->get('total_webpostotal_status');
		}

		if (isset($this->request->post['webpostotal_sort_order'])) {
			$data['total_webpostotal_sort_order'] = $this->request->post['total_webpostotal_sort_order'];
		} else {
			$data['total_webpostotal_sort_order'] = $this->config->get('total_total_sort_order')+1;
		}
		if (isset($this->request->post['webpostotal_single_ratio'])) {
			$data['total_webpostotal_single_ratio'] = $this->request->post['total_webpostotal_single_ratio'];
		} else {
			$data['total_webpostotal_single_ratio'] = $this->config->get('total_webpostotal_single_ratio');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/total/webpostotal', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/total/webpostotal')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}