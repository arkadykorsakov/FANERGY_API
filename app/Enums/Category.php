<?php

namespace App\Enums;

enum Category: string
{
	case PODCAST = 'podcast';
	case GALLERY = 'gallery';
	case TELEGRAM = 'telegram';
	case FILE = 'file';
	case AUDIO = 'audio';
	case VIDEO = 'video';
	case DISCORD = 'discord';
}
