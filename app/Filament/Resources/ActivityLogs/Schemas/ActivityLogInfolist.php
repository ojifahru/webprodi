<?php

namespace App\Filament\Resources\ActivityLogs\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ActivityLogInfolist
{
    private static function stringifyForDisplay(mixed $value, bool $pretty = false): ?string
    {
        if ($value === null) {
            return null;
        }

        if (is_string($value)) {
            return $value;
        }

        if (is_int($value) || is_float($value)) {
            return (string) $value;
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if ($value instanceof \DateTimeInterface) {
            return $value->format('Y-m-d H:i:s');
        }

        if (is_array($value) || is_object($value)) {
            $flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR;
            if ($pretty) {
                $flags |= JSON_PRETTY_PRINT;
            }

            $json = json_encode($value, $flags);

            if ($json !== false) {
                return $json;
            }

            return print_r($value, true);
        }

        return (string) $value;
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            /*
            |--------------------------------------------------------------------------
            | Activity Header (Telescope Style)
            |--------------------------------------------------------------------------
            */
            Section::make('Activity')
                ->columns(3)
                ->schema([
                    TextEntry::make('tenant.name')
                        ->label('Tenant'),
                    TextEntry::make('event')
                        ->badge()
                        ->color(fn ($state) => match ($state) {
                            'created' => 'success',
                            'updated' => 'warning',
                            'deleted' => 'danger',
                            default => 'gray',
                        }),

                    TextEntry::make('description')
                        ->weight('bold')
                        ->columnSpan(2),

                    TextEntry::make('causer.name')
                        ->label('User')
                        ->placeholder('System'),

                    TextEntry::make('subject_type')
                        ->label('Model')
                        ->formatStateUsing(fn ($state) => class_basename($state)),

                    TextEntry::make('created_at')
                        ->label('Time')
                        ->since(),
                ]),

            /*
            |--------------------------------------------------------------------------
            | Diff Highlight (BEFORE VS AFTER)
            |--------------------------------------------------------------------------
            */
            Section::make('Field Changes')
                ->collapsible()
                ->visible(fn ($record) => filled(data_get($record->properties, 'attributes')))
                ->schema([
                    RepeatableEntry::make('field_changes')
                        ->label('')
                        ->state(function ($record): array {
                            $attributes = data_get($record->properties, 'attributes') ?? [];
                            $oldValues = data_get($record->properties, 'old') ?? [];

                            if ($attributes instanceof \Illuminate\Support\Collection) {
                                $attributes = $attributes->toArray();
                            }

                            if ($oldValues instanceof \Illuminate\Support\Collection) {
                                $oldValues = $oldValues->toArray();
                            }

                            if (! is_array($attributes)) {
                                $attributes = [];
                            }

                            if (! is_array($oldValues)) {
                                $oldValues = [];
                            }

                            $diff = [];

                            foreach ($attributes as $key => $value) {
                                $diff[] = [
                                    'key' => (string) $key,
                                    'old' => self::stringifyForDisplay($oldValues[$key] ?? null),
                                    'new' => self::stringifyForDisplay($value),
                                ];
                            }

                            return $diff;
                        })
                        ->schema([
                            TextEntry::make('key')
                                ->label('Field')
                                ->weight('semibold'),

                            TextEntry::make('old')
                                ->label('Old')
                                ->color('danger')
                                ->placeholder('-'),

                            TextEntry::make('new')
                                ->label('New')
                                ->color('success'),
                        ]),
                ]),

            /*
            |--------------------------------------------------------------------------
            | Raw JSON (Accordion)
            |--------------------------------------------------------------------------
            */
            Section::make('Raw Properties')
                ->collapsible()
                ->collapsed()
                ->schema([
                    TextEntry::make('properties')
                        ->label('JSON Data')
                        ->fontFamily('mono')
                        ->formatStateUsing(fn ($state) => self::stringifyForDisplay($state, pretty: true)),
                ]),

            /*
            |--------------------------------------------------------------------------
            | Meta Info
            |--------------------------------------------------------------------------
            */
            Section::make('Meta')
                ->columns(2)
                ->schema([
                    TextEntry::make('log_name')->badge(),

                    TextEntry::make('subject_id')
                        ->label('Subject ID'),

                    TextEntry::make('updated_at')
                        ->dateTime(),
                ]),
        ]);
    }
}
