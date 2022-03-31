<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',
        'messageId',
        'mailType',
        'modelName',
        'modelId',
        'status',
        'from',
        'from_name',
        'to',
        'cc',
        'bcc',
        'replyTo',
        'body',
        'subject',
        'attachments',
        'numberOfOpens',
        'firstOpened',
        'lastOpenedFrom',
        'lastError',
        'TotalTries',
        'success',
        'deliveryInformation',
        'sendOn',
        'deliveredAt',
    ];

    /**
     * @param string $messageId
     * @return static|null
     */
    public static function byMessageId(string $messageId): ?self
    {
        return Email::where('messageId', $messageId)->first();
    }

    /**
     * @param string $deliveredAt
     */
    public function saveDelivered(string $deliveredAt): void
    {
        $this->status = 'Delivered';
        $this->deliveredAt = $deliveredAt;
        $this->save();
    }
}
