<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = ['user_id', 'action', 'subject_type', 'subject_id', 'description', 'ip_address'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Write one line to the audit log. $subject is the model that was changed (optional). */
    public static function record(string $action, string $description, $subject = null): void
    {
        static::create([
            'user_id'      => auth()->id(),
            'action'       => $action,
            'subject_type' => $subject ? class_basename($subject) : null,
            'subject_id'   => $subject?->getKey(),
            'description'  => mb_substr($description, 0, 250),
            'ip_address'   => request()->ip(),
        ]);
    }

    /** Human readable "field: old → new" list of what changed. */
    public static function diff(array $before, array $after): string
    {
        $labels = [
            'name' => 'name', 'description' => 'description', 'category_id' => 'category', 'is_drink' => 'type',
            'price' => 'price', 'price_cold' => 'cold price', 'price_hot' => 'hot price',
            'featured' => 'featured', 'active' => 'available',
            'grp' => 'group', 'price_add' => 'extra price', 'is_multi' => 'pick many',
        ];
        $fmt = fn($x) => is_bool($x) ? ($x ? 'yes' : 'no') : (($x === null || $x === '') ? '—' : (string) $x);

        $out = [];
        foreach ($after as $key => $new) {
            $old = $before[$key] ?? null;
            if ($key === 'image') {
                if ($old !== $new) {
                    $out[] = 'photo changed';
                }
                continue;
            }
            if (is_bool($new)) {
                $old = (bool) $old;
            }
            if ((string) $old === (string) $new || (is_numeric($old) && is_numeric($new) && (float) $old == (float) $new)) {
                continue;
            }
            $out[] = ($labels[$key] ?? $key) . ': ' . $fmt($old) . ' → ' . $fmt($new);
        }

        return $out ? implode(', ', $out) : 'no changes';
    }
}
