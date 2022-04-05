 <?php
/**
 *
 */
class Validate
{

    public function __construct()
    {
        # code...
    }
    function print($data) {
        return $data;
    }

    public function minlength($data, $arg)
    {

        if (is_array($data)) {
            foreach ($data as $value) {
                if (strlen($value) < $arg) {
                    return "Inputs must be more than {$arg} characters";
                    exit;
                }
            }
        } else {
            if (strlen($data) < $arg) {
                return "Input must be more than {$arg} characters";
            }
        }

    }
    public function maxlength($data, $arg)
    {

        if (is_array($data)) {
            foreach ($data as $value) {
                if (strlen($value) > $arg) {
                    return "Inputs must be lsee than {$arg} characters";
                    exit;
                }
            }
        } else {
            if (strlen($data) > $arg) {
                return "Input must be less than {$arg} characters";
            }
        }

    }

    public function digit($data)
    {
        if (is_array($data)) {
            foreach ($data as $value) {
                if (ctype_digit($value) == false) {
                    return "Inputs must be digits";
                    exit;
                }
            }
        } else {
            if (ctype_digit($data) == false) {
                return "Input must be digits";
            }
        }

    }

    public function name($name)
    {
        if (is_array($name)) {
            foreach ($name as $value) {
                if (!preg_match('/^[a-zA-Z0-9\s]+$/', $value)) {
                    return "Inputs must be valid name";
                    exit;
                }
            }
        } else {
            if (!preg_match('/^[a-zA-Z0-9\s]+$/', $name)) {
                return "Input must be valid name";
            }
        }

    }

    public function boval($check)
    {
        if (is_array($check)) {
            foreach ($check as $value) {
                if (!filter_var($value, FILTER_VALIDATE_BOOLEAN)) {
                    return "please select all";
                    exit;
                }
            }
        } else {
            if (!filter_var($check, FILTER_VALIDATE_BOOLEAN)) {
                return "please select one";
            }
        }

    }

    public function email($email)
    {

        if (is_array($email)) {
            foreach ($email as $value) {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    return "Input must be valid email";
                    exit;
                }
            }
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return "Input must be valid email";
            }
        }

    }

    public function url($url)
    {
        if (is_array($url)) {
            foreach ($url as $value) {
                if (!filter_var($value, FILTER_VALIDATE_URL)) {
                    return "Input must be valid URL";
                    exit;
                }
            }
        } else {
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                return "Input must be valid URL";
            }
        }

    }

    public function xss_prevent($data)
    {
        return trim(htmlspecialchars($data));

    }

    public function xss_prevent_obj(&$data)
    {
        foreach ($data as &$value) {
            // Check if item is an array or object, if so call this function recursively.
            if (is_array($value) || is_object($value)) {
                xss_prevent_obj($value);
            } else {
                // Otherwise, sanitize this item and continue iteration.
                $value = trim(htmlspecialchars($value));
            }
        }
        return $data;
    }

    public function xss_clean($data)
    {
        $data = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

        do {

            $old_data = $data;
            $data     = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        } while ($old_data !== $data);

        return $data;
    }

    public function xss_clean_obj(&$data)
    {

        foreach ($data as &$value) {
            if (is_array($value) || is_object($value)) {
                xss_clean_obj($value);
            } else {
                // Otherwise, sanitize this item and continue iteration.
                $value = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $value);
                $value = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $value);
                $value = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $value);
                $value = html_entity_decode($value, ENT_COMPAT, 'UTF-8');

                $value = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $value);

                $value = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $value);
                $value = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $value);
                $value = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $value);
                $value = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $value);
                $value = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $value);
                $value = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $value);

                $value = preg_replace('#</*\w+:\w[^>]*+>#i', '', $value);

                do {

                    $old_value = $value;
                    $value     = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $value);
                } while ($old_value !== $value);
            }
        }

        return $data;
    }

    
    public function checkMime($filename)
    {
        
        $finfo   = finfo_open(FILEINFO_MIME_TYPE);
        $tmpname = $filename['tmp_name'];
        if (empty($tmpname)) {
            return "Input must be valid mime ";
        } else {
            $mtype = finfo_file($finfo, $tmpname);
            if ($mtype == ("application/vnd.openxmlformats-officedocument.wordprocessingml.document") ||
                $mtype == ("application/vnd.ms-excel") ||
                $mtype == ("application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") ||
                $mtype == ("application/vnd.ms-powerpoint") ||
                $mtype == ("application/vnd.openxmlformats-officedocument.presentationml.presentation") ||
                $mtype == ("application/pdf")) {

            } else {
                return "Input must be valid mime ";
            }
        }
    }

    public function checkBydefine($filename, $allowed)
    {
        $filename = $filename['name'];
        if (is_array($filename)) {

            foreach ($filename as $value) {
                $ext = pathinfo($value, PATHINFO_EXTENSION);
                if (!in_array($ext, $allowed)) {
                    return "Input must be valid file";
                }
            }

        } else {
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (!in_array($ext, $allowed)) {
                return "Input must be valid file";
            }

        }

    }

    public function checkImage($filename)
    {
        $filename = $filename['name'];

        if (is_array($filename)) {
            foreach ($filename as $key => $value) {
                $ext  = pathinfo($value, PATHINFO_EXTENSION);
                $path = $filename[$key];

                switch ($ext) {
                    case 'png':$ret = @imagecreatefrompng($path);
                        break;
                    case 'jpeg':$ret = @imagecreatefromjpeg($path);
                        break;
                    case 'png':$ret = @imagecreatefromjpeg($path);
                        break;
                    // ...
                    default:$ret = "Input must be valid image file";
                }
            }

        } else {
            $ext  = pathinfo($filename, PATHINFO_EXTENSION);
            $path = $filename;
            switch ($ext) {
                case 'png':$ret = @imagecreatefrompng($path);
                    break;
                case 'jpeg':$ret = @imagecreatefromjpeg($path);
                    break;
                case 'png':$ret = @imagecreatefromjpeg($path);
                    break;
                // ...
                default:$ret = "Input must be valid image file";
            }
        }

        return $ret;
    }

    public function checkSize($filename, $size)
    {
        $fileSize = $filename['size'];
        if (is_array($fileSize)) {
            foreach ($fileSize as $key => $value) {
                if ($value > $size) {
                    return "Sorry, your files are too large.";
                    exit;
                }
            }
        } else {
            if ($fileSize > $size) {
                return "Sorry, your file is too large.";
            }
        }

    }

    public function fileExist($filename, $targetdir)
    {

        $name = $filename["name"];
        if (is_array($name)) {
            foreach ($tmp_name as $key => $value) {
                $target_file = $targetdir . basename($value);
                if (file_exists($target_file)) {
                    return "Sorry, file already exists.";
                    exit;
                }
            }

        } else {
            $target_file = $targetdir . basename($name);
            if (file_exists($target_file)) {
                return "Sorry, file already exists.";
            }
        }

    }

    public function getMimeType($ext)
    {
        $ext = strtolower($ext);
        if (!(strpos($ext, '.') !== false)) {
            $ext = '.' . $ext;
        }
        switch ($ext) {
            case '.aac':$mime = 'audio/aac';
                break; // AAC audio
            case '.abw':$mime = 'application/x-abiword';
                break; // AbiWord document
            case '.arc':$mime = 'application/octet-stream';
                break; // Archive document (multiple files embedded)
            case '.avi':$mime = 'video/x-msvideo';
                break; // AVI: Audio Video Interleave
            case '.azw':$mime = 'application/vnd.amazon.ebook';
                break; // Amazon Kindle eBook format
            case '.bin':$mime = 'application/octet-stream';
                break; // Any kind of binary data
            case '.bmp':$mime = 'image/bmp';
                break; // Windows OS/2 Bitmap Graphics
            case '.bz':$mime = 'application/x-bzip';
                break; // BZip archive
            case '.bz2':$mime = 'application/x-bzip2';
                break; // BZip2 archive
            case '.csh':$mime = 'application/x-csh';
                break; // C-Shell script
            case '.css':$mime = 'text/css';
                break; // Cascading Style Sheets (CSS)
            case '.csv':$mime = 'text/csv';
                break; // Comma-separated values (CSV)
            case '.doc':$mime = 'application/msword';
                break; // Microsoft Word
            case '.docx':$mime = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
                break; // Microsoft Word (OpenXML)
            case '.eot':$mime = 'application/vnd.ms-fontobject';
                break; // MS Embedded OpenType fonts
            case '.epub':$mime = 'application/epub+zip';
                break; // Electronic publication (EPUB)
            case '.gif':$mime = 'image/gif';
                break; // Graphics Interchange Format (GIF)
            case '.htm':$mime = 'text/html';
                break; // HyperText Markup Language (HTML)
            case '.html':$mime = 'text/html';
                break; // HyperText Markup Language (HTML)
            case '.ico':$mime = 'image/x-icon';
                break; // Icon format
            case '.ics':$mime = 'text/calendar';
                break; // iCalendar format
            case '.jar':$mime = 'application/java-archive';
                break; // Java Archive (JAR)
            case '.jpeg':$mime = 'image/jpeg';
                break; // JPEG images
            case '.jpg':$mime = 'image/jpeg';
                break; // JPEG images
            case '.js':$mime = 'application/javascript';
                break; // JavaScript (IANA Specification) (RFC 4329 Section 8.2)
            case '.json':$mime = 'application/json';
                break; // JSON format
            case '.mid':$mime = 'audio/midi audio/x-midi';
                break; // Musical Instrument Digital Interface (MIDI)
            case '.midi':$mime = 'audio/midi audio/x-midi';
                break; // Musical Instrument Digital Interface (MIDI)
            case '.mpeg':$mime = 'video/mpeg';
                break; // MPEG Video
            case '.mpkg':$mime = 'application/vnd.apple.installer+xml';
                break; // Apple Installer Package
            case '.odp':$mime = 'application/vnd.oasis.opendocument.presentation';
                break; // OpenDocument presentation document
            case '.ods':$mime = 'application/vnd.oasis.opendocument.spreadsheet';
                break; // OpenDocument spreadsheet document
            case '.odt':$mime = 'application/vnd.oasis.opendocument.text';
                break; // OpenDocument text document
            case '.oga':$mime = 'audio/ogg';
                break; // OGG audio
            case '.ogv':$mime = 'video/ogg';
                break; // OGG video
            case '.ogx':$mime = 'application/ogg';
                break; // OGG
            case '.otf':$mime = 'font/otf';
                break; // OpenType font
            case '.png':$mime = 'image/png';
                break; // Portable Network Graphics
            case '.pdf':$mime = 'application/pdf';
                break; // Adobe Portable Document Format (PDF)
            case '.ppt':$mime = 'application/vnd.ms-powerpoint';
                break; // Microsoft PowerPoint
            case '.pptx':$mime = 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
                break; // Microsoft PowerPoint (OpenXML)
            case '.rar':$mime = 'application/x-rar-compressed';
                break; // RAR archive
            case '.rtf':$mime = 'application/rtf';
                break; // Rich Text Format (RTF)
            case '.sh':$mime = 'application/x-sh';
                break; // Bourne shell script
            case '.svg':$mime = 'image/svg+xml';
                break; // Scalable Vector Graphics (SVG)
            case '.swf':$mime = 'application/x-shockwave-flash';
                break; // Small web format (SWF) or Adobe Flash document
            case '.tar':$mime = 'application/x-tar';
                break; // Tape Archive (TAR)
            case '.tif':$mime = 'image/tiff';
                break; // Tagged Image File Format (TIFF)
            case '.tiff':$mime = 'image/tiff';
                break; // Tagged Image File Format (TIFF)
            case '.ts':$mime = 'application/typescript';
                break; // Typescript file
            case '.ttf':$mime = 'font/ttf';
                break; // TrueType Font
            case '.txt':$mime = 'text/plain';
                break; // Text, (generally ASCII or ISO 8859-n)
            case '.vsd':$mime = 'application/vnd.visio';
                break; // Microsoft Visio
            case '.wav':$mime = 'audio/wav';
                break; // Waveform Audio Format
            case '.weba':$mime = 'audio/webm';
                break; // WEBM audio
            case '.webm':$mime = 'video/webm';
                break; // WEBM video
            case '.webp':$mime = 'image/webp';
                break; // WEBP image
            case '.woff':$mime = 'font/woff';
                break; // Web Open Font Format (WOFF)
            case '.woff2':$mime = 'font/woff2';
                break; // Web Open Font Format (WOFF)
            case '.xhtml':$mime = 'application/xhtml+xml';
                break; // XHTML
            case '.xls':$mime = 'application/vnd.ms-excel';
                break; // Microsoft Excel
            case '.xlsx':$mime = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
                break; // Microsoft Excel (OpenXML)
            case '.xml':$mime = 'application/xml';
                break; // XML
            case '.xul':$mime = 'application/vnd.mozilla.xul+xml';
                break; // XUL
            case '.zip':$mime = 'application/zip';
                break; // ZIP archive
            case '.3gp':$mime = 'video/3gpp';
                break; // 3GPP audio/video container
            case '.3g2':$mime = 'video/3gpp2';
                break; // 3GPP2 audio/video container
            case '.7z':$mime = 'application/x-7z-compressed';
                break; // 7-zip archive
            default:$mime = 'application/octet-stream'; // general purpose MIME-type
        }
        return $mime;

    }

}
