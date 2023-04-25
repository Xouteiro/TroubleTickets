<?php
declare(strict_types=1);

class FAQ
{

    public int $id;

    public int $department_id;
    public string $question;
    public string $answer;

    public function __construct(int $id, int $department_id, string $question, string $answer)
    {
        $this->id = $id;
        $this->department_id = $department_id;
        $this->question = $question;
        $this->answer = $answer;
    }

    public function updateFAQ(PDO $db, int $id, int $department_id, string $question, string $answer): bool
    {
        $stmt = $db->prepare('UPDATE FAQS SET department_id = ?, question = ?, answer = ? WHERE faq_id = ?');
        try {
            $stmt->execute(array($department_id, $question, $answer, $id));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getFAQS(PDO $db, int $count): array
    {
        $stmt = $db->prepare('SELECT faq_id, department_id, question, answer FROM FAQS LIMIT ?');
        $stmt->execute(array($count));

        $faqs = array();
        while ($faq = $stmt->fetch()) {
            $faqs[] = new FAQ(
                $faq['faq_id'],
                $faq['department_id'],
                $faq['question'],
                $faq['answer']
            );
        }
        return $faqs;
    }

    public function getFAQById(PDO $db, int $id): ?FAQ
    {
        $stmt = $db->prepare('SELECT faq_id, department_id, question, answer FROM FAQS WHERE faq_id = ?');
        $stmt->execute(array($id));

        $faq = $stmt->fetch();
        if ($faq) {
            return new FAQ(
                intval($faq['faq_id']),
                $faq['department_id'],
                $faq['question'],
                $faq['answer']
            );
        }
        return null;
    }

    public function newFAQ(PDO $db, int $department_id, string $question, string $answer): bool
    {
        $stmt = $db->prepare('INSERT INTO FAQS (department_id, question, answer) VALUES (?, ?, ?)');
        try {
            $stmt->execute(array($department_id, $question, $answer));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getFAQByDepartment(PDO $db, int $department_id): array
    {
        $stmt = $db->prepare('SELECT faq_id, department_id, question, answer FROM FAQS WHERE department_id = ?');
        $stmt->execute(array($department_id));

        $faqs = array();
        while ($faq = $stmt->fetch()) {
            $faqs[] = new FAQ(
                $faq['faq_id'],
                $faq['department_id'],
                $faq['question'],
                $faq['answer']
            );
        }
        return $faqs;
    }

}

?>