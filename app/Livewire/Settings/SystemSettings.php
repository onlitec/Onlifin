<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

class SystemSettings extends Component
{
    public $smtp_host;
    public $smtp_port;
    public $smtp_username;
    public $smtp_password;
    public $smtp_encryption;
    public $mail_from_address;
    public $mail_from_name;

    public function mount()
    {
        $this->smtp_host = config('mail.mailers.smtp.host');
        $this->smtp_port = config('mail.mailers.smtp.port');
        $this->smtp_username = config('mail.mailers.smtp.username');
        $this->smtp_password = config('mail.mailers.smtp.password');
        $this->smtp_encryption = config('mail.mailers.smtp.encryption');
        $this->mail_from_address = config('mail.from.address');
        $this->mail_from_name = config('mail.from.name');
    }

    public function saveSettings()
    {
        $this->validate([
            'smtp_host' => 'required',
            'smtp_port' => 'required|numeric',
            'smtp_username' => 'required|email',
            'smtp_password' => 'required',
            'smtp_encryption' => 'required|in:tls,ssl',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required'
        ]);

        // Salvar no .env
        $this->updateEnvValue('MAIL_HOST', $this->smtp_host);
        $this->updateEnvValue('MAIL_PORT', $this->smtp_port);
        $this->updateEnvValue('MAIL_USERNAME', $this->smtp_username);
        $this->updateEnvValue('MAIL_PASSWORD', $this->smtp_password);
        $this->updateEnvValue('MAIL_ENCRYPTION', $this->smtp_encryption);
        $this->updateEnvValue('MAIL_FROM_ADDRESS', $this->mail_from_address);
        $this->updateEnvValue('MAIL_FROM_NAME', $this->mail_from_name);

        session()->flash('success', 'Configurações salvas com sucesso!');
    }

    private function updateEnvValue($key, $value)
    {
        $path = base_path('.env');
        $content = file_get_contents($path);

        // Se a chave existir, atualiza o valor
        if (strpos($content, "{$key}=") !== false) {
            $content = preg_replace(
                "/^{$key}=.*/m",
                "{$key}=" . $value,
                $content
            );
        } else {
            // Se não existir, adiciona no final
            $content .= "\n{$key}=" . $value;
        }

        file_put_contents($path, $content);
    }

    public function render()
    {
        return view('livewire.settings.system-settings');
    }
} 