    <?php
    class Hashtag {
        public ?int $hashtag_id;
        public string $hashtag_name;

        public function __construct(?int $hashtag_id, string $hashtag_name) {
            $this->hashtag_id = $hashtag_id;
            $this->hashtag_name = $hashtag_name;
        }
            
        static function getTicketHashtags(PDO $db, int $ticket_id): array {
            $sql = "SELECT TICKET_HASHTAGS.hashtag_id, HASHTAGS.hashtag_name FROM TICKET_HASHTAGS JOIN HASHTAGS ON TICKET_HASHTAGS.hashtag_id = HASHTAGS.hashtag_id WHERE ticket_id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$ticket_id]);
            $hashtags = array();
            while ($hashtag = $stmt->fetch()) {
                $hashtags[] = new Hashtag(
                    $hashtag['hashtag_id'],
                    $hashtag['hashtag_name']
                );
            }
            return $hashtags;
            }

            static function removeTicketHashtag(PDO $db, int $ticket_id, int $hashtag_id): bool {
                $sql = "DELETE FROM TICKET_HASHTAGS WHERE ticket_id = ? AND hashtag_id = ?";
                $stmt = $db->prepare($sql);
                $result = $stmt->execute([$ticket_id, $hashtag_id]);
                return $result;
            }
            
            static function createTicketHashtag(PDO $db, int $ticket_id, string $hashtag_name): ?Hashtag {
                // Check if the hashtag already exists in the database
                $stmt = $db->prepare("SELECT hashtag_id FROM HASHTAGS WHERE hashtag_name = ?");
                $stmt->execute([$hashtag_name]);
                $hashtag_id = $stmt->fetchColumn();
            
                // If the hashtag doesn't exist, insert it into the database
                if (!$hashtag_id) {
                    $stmt = $db->prepare("INSERT INTO HASHTAGS (hashtag_name) VALUES (?)");
                    $stmt->execute([$hashtag_name]);
                    $hashtag_id = $db->lastInsertId();
                }
            
                // Check if the hashtag is already associated with the ticket
                $stmt = $db->prepare("SELECT COUNT(*) FROM TICKET_HASHTAGS WHERE ticket_id = ? AND hashtag_id = ?");
                $stmt->execute([$ticket_id, $hashtag_id]);
                $count = $stmt->fetchColumn();
            
                // If the hashtag is not associated with the ticket, insert the new record
                if ($count == 0) {
                    $stmt = $db->prepare("INSERT INTO TICKET_HASHTAGS (ticket_id, hashtag_id) VALUES (?, ?)");
                    $stmt->execute([$ticket_id, $hashtag_id]);
                }
            
                // Return the Hashtag object
                return new Hashtag($hashtag_id, $hashtag_name);
            }
            
            
        
    }
    ?>